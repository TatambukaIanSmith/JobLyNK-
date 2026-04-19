<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Debug logging
        \Illuminate\Support\Facades\Log::info('CreateNewUser called with input:', $input);
        
        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'accountType' => ['required', 'string', Rule::in(['worker', 'employer'])],
            'phone' => [
                'nullable', 
                'string', 
                'max:255',
                Rule::unique(User::class)->whereNotNull('phone'),
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ], [
            // Custom error messages
            'email.unique' => 'An account with this email address already exists. Please use a different email or try logging in.',
            'phone.unique' => 'An account with this phone number already exists. Please use a different phone number.',
            'accountType.required' => 'Please select whether you want to join as a Worker or Employer.',
            'accountType.in' => 'Please select a valid account type (Worker or Employer).',
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Your password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Additional custom validation for existing users
        $validator->after(function ($validator) use ($input) {
            // Check if user exists with same email (case-insensitive)
            $existingUser = User::whereRaw('LOWER(email) = ?', [strtolower($input['email'])])->first();
            if ($existingUser) {
                $validator->errors()->add('email', 'An account with this email address already exists. Did you mean to log in instead?');
            }

            // If phone is provided, check for duplicates (case-insensitive and normalized)
            if (!empty($input['phone'])) {
                $normalizedPhone = preg_replace('/[^0-9+]/', '', $input['phone']);
                $existingPhone = User::whereNotNull('phone')
                    ->where(function($query) use ($input, $normalizedPhone) {
                        $query->where('phone', $input['phone'])
                              ->orWhere('phone', $normalizedPhone)
                              ->orWhereRaw('REPLACE(REPLACE(REPLACE(phone, " ", ""), "-", ""), "(", "") = ?', [$normalizedPhone]);
                    })
                    ->first();
                
                if ($existingPhone) {
                    $validator->errors()->add('phone', 'An account with this phone number already exists.');
                }
            }
        });

        // Validate and log any errors
        try {
            $validator->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Validation failed in CreateNewUser:', $e->errors());
            throw $e;
        }

        // Create the user
        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'role' => $input['accountType'],
                'phone' => $input['phone'] ?? null,
                'location' => $input['location'] ?? null,
                'bio' => $input['bio'] ?? null,
            ]);
            
            \Illuminate\Support\Facades\Log::info('User created successfully:', ['id' => $user->id, 'email' => $user->email, 'role' => $user->role]);
            
            return $user;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to create user:', ['error' => $e->getMessage(), 'input' => $input]);
            throw $e;
        }
    }
}
