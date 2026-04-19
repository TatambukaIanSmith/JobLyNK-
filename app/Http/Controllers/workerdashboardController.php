<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobNotificationService;
use Illuminate\Support\Facades\Auth;

class workerdashboardController extends Controller
{
    protected JobNotificationService $notificationService;

    public function __construct(JobNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function worker()
    {
        $user = Auth::user();
        
        // Get notification summary for the worker
        $notificationSummary = $this->notificationService->getNotificationSummary($user);
        
        return view('files.worker', [
            'unreadNotificationsCount' => $notificationSummary['unread_count'],
            'recentNotifications' => $notificationSummary['recent_notifications'],
            'totalNotifications' => $notificationSummary['total_notifications'],
            'applicationsCount' => $user->applications()->count(),
            'jobMatchesCount' => $user->unreadJobNotifications()->where('type', 'job_match')->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
}
