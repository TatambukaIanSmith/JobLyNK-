<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;

class TokenRevocationService
{
    /**
     * Revoke all API tokens for a user
     */
    public function revokeAllUserTokens(int $userId): void
    {
        try {
            // Revoke Sanctum tokens if available
            if (class_exists(PersonalAccessToken::class)) {
                $tokenCount = PersonalAccessToken::where('tokenable_id', $userId)
                    ->where('tokenable_type', 'App\Models\User')
                    ->delete();
                
                Log::info("Revoked {$tokenCount} Sanctum tokens for user: {$userId}");
            }

            // Revoke custom API tokens if you have them
            $customTokenCount = DB::table('api_tokens')
                ->where('user_id', $userId)
                ->delete();

            if ($customTokenCount > 0) {
                Log::info("Revoked {$customTokenCount} custom API tokens for user: {$userId}");
            }

            // Clear token cache
            Cache::forget("user.{$userId}.api_tokens");
            
        } catch (\Exception $e) {
            Log::error("Failed to revoke tokens for user {$userId}: " . $e->getMessage());
        }
    }

    /**
     * Revoke specific token
     */
    public function revokeToken(string $tokenId): bool
    {
        try {
            if (class_exists(PersonalAccessToken::class)) {
                $token = PersonalAccessToken::find($tokenId);
                if ($token) {
                    $userId = $token->tokenable_id;
                    $token->delete();
                    
                    // Clear user token cache
                    Cache::forget("user.{$userId}.api_tokens");
                    
                    Log::info("Revoked token: {$tokenId} for user: {$userId}");
                    return true;
                }
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error("Failed to revoke token {$tokenId}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Revoke tokens by name/type
     */
    public function revokeTokensByName(int $userId, string $tokenName): void
    {
        try {
            if (class_exists(PersonalAccessToken::class)) {
                $tokenCount = PersonalAccessToken::where('tokenable_id', $userId)
                    ->where('tokenable_type', 'App\Models\User')
                    ->where('name', $tokenName)
                    ->delete();
                
                Log::info("Revoked {$tokenCount} '{$tokenName}' tokens for user: {$userId}");
            }

            // Clear token cache
            Cache::forget("user.{$userId}.api_tokens");
            
        } catch (\Exception $e) {
            Log::error("Failed to revoke '{$tokenName}' tokens for user {$userId}: " . $e->getMessage());
        }
    }

    /**
     * Get active tokens for a user
     */
    public function getActiveTokens(int $userId): array
    {
        try {
            if (class_exists(PersonalAccessToken::class)) {
                return PersonalAccessToken::where('tokenable_id', $userId)
                    ->where('tokenable_type', 'App\Models\User')
                    ->select('id', 'name', 'abilities', 'last_used_at', 'created_at')
                    ->get()
                    ->toArray();
            }
            
            return [];
        } catch (\Exception $e) {
            Log::error("Failed to get active tokens for user {$userId}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Clean up expired tokens
     */
    public function cleanupExpiredTokens(): void
    {
        try {
            if (class_exists(PersonalAccessToken::class)) {
                $expiredCount = PersonalAccessToken::where('expires_at', '<', now())
                    ->delete();
                
                Log::info("Cleaned up {$expiredCount} expired tokens");
            }
        } catch (\Exception $e) {
            Log::error("Failed to cleanup expired tokens: " . $e->getMessage());
        }
    }

    /**
     * Blacklist token (for JWT or custom tokens)
     */
    public function blacklistToken(string $token): void
    {
        try {
            // Add token to blacklist cache
            $tokenHash = hash('sha256', $token);
            Cache::put("blacklisted_token.{$tokenHash}", true, now()->addDays(30));
            
            Log::info("Token blacklisted: " . substr($tokenHash, 0, 8) . '...');
        } catch (\Exception $e) {
            Log::error("Failed to blacklist token: " . $e->getMessage());
        }
    }

    /**
     * Check if token is blacklisted
     */
    public function isTokenBlacklisted(string $token): bool
    {
        try {
            $tokenHash = hash('sha256', $token);
            return Cache::has("blacklisted_token.{$tokenHash}");
        } catch (\Exception $e) {
            Log::error("Failed to check token blacklist: " . $e->getMessage());
            return false;
        }
    }
}