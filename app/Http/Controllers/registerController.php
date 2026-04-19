<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class registerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register()
    {
        return view('files.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the registration data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'accountType' => ['required', 'in:worker,employer'],
            'country_code' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'location' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'string', 'max:10'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'terms' => ['required', 'accepted'],
        ]);

        // Combine country code with phone number
        $fullPhoneNumber = $request->country_code . $request->phone;

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->accountType,
            'phone' => $fullPhoneNumber,
            'location' => $request->location,
            'age' => $request->age,
            'bio' => $request->bio,
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect based on account type with success message
        if ($user->role === 'employer') {
            return redirect()->route('employerDashboard')->with('success', 'Welcome to JOB-lyNK! Your employer account has been created successfully.');
        } else {
            return redirect()->route('worker')->with('success', 'Welcome to JOB-lyNK! Your worker account has been created successfully.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Handle talent network registration with extended profile data
     */
    public function talentNetworkRegister(Request $request)
    {
        // Validate the talent network registration data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:15'],
            'gender' => ['required', 'in:male,female,other'],
            'country' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
            'experience_years' => ['required', 'string'],
            'education_level' => ['required', 'string'],
            'work_history' => ['nullable', 'string', 'max:2000'],
            'availability' => ['required', 'string'],
            'wage_min' => ['nullable', 'numeric', 'min:0'],
            'wage_max' => ['nullable', 'numeric', 'min:0'],
            'job_types' => ['nullable', 'array'],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        // Create bio from work history and experience
        $bio = $request->work_history ?? '';
        if ($request->experience_years) {
            $bio .= "\n\nExperience: " . $request->experience_years;
        }
        if ($request->education_level) {
            $bio .= "\nEducation: " . ucfirst($request->education_level);
        }
        if ($request->availability) {
            $bio .= "\nAvailability: " . ucfirst(str_replace('_', ' ', $request->availability));
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'worker',
            'phone' => $request->phone,
            'location' => $request->location,
            'bio' => trim($bio),
        ]);

        // Store skills if provided
        if ($request->skills) {
            $skills = explode(',', $request->skills);
            foreach ($skills as $skillName) {
                $skillName = trim($skillName);
                if (!empty($skillName)) {
                    // Find or create skill
                    $skill = \App\Models\Skill::firstOrCreate(
                        ['name' => $skillName],
                        ['category' => 'General']
                    );
                    
                    // Attach skill to user
                    \App\Models\UserSkill::create([
                        'user_id' => $user->id,
                        'skill_id' => $skill->id,
                        'proficiency_level' => 'intermediate'
                    ]);
                }
            }
        }

        // Store job preferences if provided
        if ($request->wage_min || $request->wage_max || $request->job_types) {
            \App\Models\UserJobPreference::create([
                'user_id' => $user->id,
                'preferred_job_types' => $request->job_types ? json_encode($request->job_types) : null,
                'min_salary' => $request->wage_min,
                'max_salary' => $request->wage_max,
                'availability_status' => $request->availability,
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Redirect to worker dashboard with success message
        return redirect()->route('worker')->with('success', 'Welcome to the JOB-lyNK Talent Network! Your profile has been created successfully.');
    }
}
