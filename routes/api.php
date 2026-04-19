<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SkillsController;
use App\Http\Controllers\Api\UserSkillsController;
use App\Http\Controllers\Api\UserCheckController;
use App\Http\Controllers\Api\SkillToCashController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['web', 'auth']);

// Skills API routes
Route::middleware(['web', 'auth'])->group(function () {
    // Skills management
    Route::get('/skills', [SkillsController::class, 'index']);
    Route::post('/skills', [SkillsController::class, 'store']);
    Route::get('/skills/{skill}', [SkillsController::class, 'show']);
    Route::put('/skills/{skill}', [SkillsController::class, 'update']);
    Route::delete('/skills/{skill}', [SkillsController::class, 'destroy']);

    // User skills management
    Route::get('/user/skills', [UserSkillsController::class, 'index']);
    Route::post('/user/skills', [UserSkillsController::class, 'store']);
    Route::put('/user/skills/{userSkill}', [UserSkillsController::class, 'update']);
    Route::delete('/user/skills/{userSkill}', [UserSkillsController::class, 'destroy']);

    // User preferences and notifications
    Route::get('/user/preferences', [UserSkillsController::class, 'getPreferences']);
    Route::post('/user/preferences', [UserSkillsController::class, 'updatePreferences']);
    Route::get('/user/notifications', [UserSkillsController::class, 'getNotifications']);
    Route::post('/user/notifications/{notification}/read', [UserSkillsController::class, 'markNotificationRead']);

    // Skill-to-Cash API routes
    Route::prefix('skill-to-cash')->group(function () {
        Route::get('/profile', [SkillToCashController::class, 'getProfile']);
        Route::post('/profile', [SkillToCashController::class, 'saveProfile']);
        Route::get('/matches', [SkillToCashController::class, 'getJobMatches']);
        Route::put('/visibility', [SkillToCashController::class, 'updateVisibility']);
        Route::get('/stats', [SkillToCashController::class, 'getStats']);
    });
    
    // Employer notifications
    Route::get('/employer/worker-notifications', [UserSkillsController::class, 'getEmployerWorkerNotifications']);
    
    // Worker profile for employers
    Route::get('/worker/{workerId}/profile', [UserSkillsController::class, 'getWorkerProfile']);
    
    // Job details for admin
    Route::get('/jobs/{job}', [\App\Http\Controllers\Api\JobsController::class, 'show']);
    Route::get('/jobs', [\App\Http\Controllers\Api\JobsController::class, 'index']);
});

// Public API routes (no authentication required)
Route::get('/user/check', [UserCheckController::class, 'checkUser']);