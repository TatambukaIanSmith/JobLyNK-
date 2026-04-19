<?php

namespace App\Http\Controllers;

use App\Services\EmployerAIAgentService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAIFeedbackController extends Controller
{
    protected $aiAgentService;

    public function __construct(EmployerAIAgentService $aiAgentService)
    {
        $this->aiAgentService = $aiAgentService;
    }

    /**
     * Get AI feedback for all employers (Admin only)
     */
    public function getEmployerFeedback()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $employers = User::where('role', 'employer')->get();
        $feedbackData = [];

        foreach ($employers as $employer) {
            $insights = $this->aiAgentService->generateInsights($employer);
            $feedbackData[] = $insights['admin_feedback'];
        }

        return response()->json([
            'success' => true,
            'employer_feedback' => $feedbackData,
            'summary' => $this->generateAdminSummary($feedbackData)
        ]);
    }

    /**
     * Get specific employer AI feedback (Admin only)
     */
    public function getSpecificEmployerFeedback($employerId)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $employer = User::where('role', 'employer')->findOrFail($employerId);
        $insights = $this->aiAgentService->generateInsights($employer);

        return response()->json([
            'success' => true,
            'employer_feedback' => $insights['admin_feedback'],
            'full_insights' => $insights
        ]);
    }

    /**
     * Get AI agent activity logs (Admin only)
     */
    public function getAIActivityLogs()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // This would typically read from log files or a dedicated table
        // For now, we'll return a summary
        $employers = User::where('role', 'employer')->get();
        $activitySummary = [];

        foreach ($employers as $employer) {
            $insights = $this->aiAgentService->generateInsights($employer);
            $activitySummary[] = [
                'employer_id' => $employer->id,
                'employer_name' => $employer->name,
                'last_activity' => now(),
                'alerts_generated' => count($insights['alerts']),
                'recommendations_provided' => count($insights['recommendations']),
                'performance_score' => $insights['admin_feedback']['performance_score'],
                'engagement_level' => $insights['admin_feedback']['engagement_level']
            ];
        }

        return response()->json([
            'success' => true,
            'activity_logs' => $activitySummary,
            'total_employers' => count($activitySummary),
            'avg_performance_score' => collect($activitySummary)->avg('performance_score')
        ]);
    }

    /**
     * Generate admin summary from feedback data
     */
    private function generateAdminSummary(array $feedbackData): array
    {
        $totalEmployers = count($feedbackData);
        $highPerformers = collect($feedbackData)->where('performance_score', '>=', 80)->count();
        $needsSupport = collect($feedbackData)->where('performance_score', '<', 50)->count();
        $avgScore = collect($feedbackData)->avg('performance_score');

        return [
            'total_employers' => $totalEmployers,
            'high_performers' => $highPerformers,
            'needs_support' => $needsSupport,
            'average_performance_score' => round($avgScore, 1),
            'engagement_distribution' => [
                'high' => collect($feedbackData)->where('engagement_level', 'High')->count(),
                'medium' => collect($feedbackData)->where('engagement_level', 'Medium')->count(),
                'low' => collect($feedbackData)->where('engagement_level', 'Low')->count()
            ],
            'recommendations' => [
                'focus_on_low_performers' => $needsSupport > 0 ? "Consider reaching out to $needsSupport employers who need support." : null,
                'celebrate_high_performers' => $highPerformers > 0 ? "Recognize $highPerformers high-performing employers." : null,
                'overall_health' => $avgScore >= 70 ? 'Platform employer health is good.' : 'Platform employer engagement needs improvement.'
            ]
        ];
    }
}