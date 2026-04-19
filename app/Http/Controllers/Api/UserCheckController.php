<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserCheckController extends Controller
{
    /**
     * Check if email is available for registration
     */
    public function checkEmail(Request $request): JsonResponse
    {
        $email = $request->input('email');
        
        if (empty($email)) {
            return response()->json([
                'available' => false,
                'message' => 'Email is required'
            ], 400);
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'available' => false,
                'message' => 'Invalid email format'
            ], 400);
        }

        // Check if email exists (case-insensitive)
        $existingUser = User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();
        
        if ($existingUser) {
            return response()->json([
                'available' => false,
                'message' => 'An account with this email already exists',
                'suggestion' => 'Try logging in instead'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Email is available'
        ]);
    }

    /**
     * Check if phone number is available for registration
     */
    public function checkPhone(Request $request): JsonResponse
    {
        $phone = $request->input('phone');
        
        if (empty($phone)) {
            return response()->json([
                'available' => true,
                'message' => 'Phone number is optional'
            ]);
        }

        // Normalize phone number for comparison
        $normalizedPhone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Check if phone exists
        $existingPhone = User::whereNotNull('phone')
            ->where(function($query) use ($phone, $normalizedPhone) {
                $query->where('phone', $phone)
                      ->orWhere('phone', $normalizedPhone)
                      ->orWhereRaw('REPLACE(REPLACE(REPLACE(phone, " ", ""), "-", ""), "(", "") = ?', [$normalizedPhone]);
            })
            ->first();
        
        if ($existingPhone) {
            return response()->json([
                'available' => false,
                'message' => 'An account with this phone number already exists'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Phone number is available'
        ]);
    }
}