<?php

namespace App\Http\Controllers;

use App\Services\EmployerAIAgentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerAIAgentController extends Controller
{
    protected $aiAgentService;

    public function __construct(EmployerAIAgentService $aiAgentService)
    {
        $this->aiAgentService = $aiAgentService;
    }

    /**
     * Get AI agent insights for employer dashboard
     */
    public function getInsights()
    {
        $employer = Auth::user();
        
        if ($employer->role !== 'employer') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $insights = $this->aiAgentService->generateInsights($employer);
        
        return response()->json([
            'success' => true,
            'insights' => $insights
        ]);
    }

    /**
     * Get AI agent widget for employer dashboard
     */
    public function getWidget()
    {
        $employer = Auth::user();
        
        if ($employer->role !== 'employer') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $insights = $this->aiAgentService->generateInsights($employer);
        
        return view('components.ai-agent-widget', compact('insights'));
    }

    /**
     * Get specific AI recommendations
     */
    public function getRecommendations()
    {
        $employer = Auth::user();
        
        if ($employer->role !== 'employer') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $insights = $this->aiAgentService->generateInsights($employer);
        
        return response()->json([
            'success' => true,
            'recommendations' => $insights['recommendations'],
            'troubleshooting' => $insights['troubleshooting']
        ]);
    }

    /**
     * Handle AI chat conversation
     */
    public function chat(Request $request)
    {
        $employer = Auth::user();
        
        if ($employer->role !== 'employer') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $validated['message'];
        
        // Generate AI response based on user message and employer data
        $aiResponse = $this->generateAIResponse($userMessage, $employer);
        
        return response()->json([
            'success' => true,
            'response' => $aiResponse,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Generate AI response based on user message and employer context
     */
    private function generateAIResponse(string $message, $employer): string
    {
        $insights = $this->aiAgentService->generateInsights($employer);
        $lowerMessage = strtolower($message);
        
        // Context-aware responses based on employer data
        $jobCount = $insights['job_performance']['active_jobs'];
        $applications = $insights['job_performance']['total_applications'];
        $views = $insights['job_performance']['total_views'];
        $score = $insights['admin_feedback']['performance_score'];
        
        // Keyword-based response generation
        if (strpos($lowerMessage, 'help') !== false || strpos($lowerMessage, 'how') !== false) {
            $responses = [
                "I'm here to help you optimize your hiring process! You currently have {$jobCount} active jobs with {$applications} total applications. What specific area would you like assistance with?",
                "Happy to help! Based on your data, I can provide insights on job posting, application management, or performance improvement. What interests you most?",
                "I can assist with various aspects of hiring. Your current performance score is {$score}/100. Would you like tips on improving it?"
            ];
        }
        elseif (strpos($lowerMessage, 'job') !== false || strpos($lowerMessage, 'post') !== false) {
            $responses = [
                "Great question about jobs! You have {$jobCount} active job postings that have received {$views} total views. To improve visibility, consider updating job descriptions with specific skills and competitive budgets.",
                "For better job performance, I recommend: 1) Use clear, specific job titles, 2) Include detailed requirements, 3) Offer competitive pay rates. Your jobs are getting {$views} views - let's increase that!",
                "Job posting tip: Jobs with budgets above UGX 30,000 receive 40% more applications. Your current jobs have attracted {$applications} applications total."
            ];
        }
        elseif (strpos($lowerMessage, 'application') !== false || strpos($lowerMessage, 'candidate') !== false) {
            $responses = [
                "You've received {$applications} applications across your jobs! To attract more quality candidates, respond within 24 hours and provide clear job expectations. Fast responses increase acceptance rates by 60%.",
                "Application management tip: Review applications promptly and provide feedback. You have {$applications} applications to review. Quick responses show professionalism and attract better candidates.",
                "To improve application quality, be specific about required skills and experience. Your {$jobCount} active jobs can attract more targeted applications with detailed descriptions."
            ];
        }
        elseif (strpos($lowerMessage, 'improve') !== false || strpos($lowerMessage, 'better') !== false || strpos($lowerMessage, 'tips') !== false) {
            $responses = [
                "Here are my top recommendations for improvement: 1) Respond to applications within 24 hours, 2) Use featured jobs for important positions, 3) Set competitive budgets above UGX 30,000. Your current score is {$score}/100.",
                "To boost your performance from {$score}/100: Post more detailed job descriptions, increase your budget ranges, and consider featuring your most important positions for 5x more visibility.",
                "Quick wins for better results: 1) Add specific skills to job requirements, 2) Include growth opportunities in descriptions, 3) Respond quickly to applications. This can improve your {$score}/100 score significantly."
            ];
        }
        elseif (strpos($lowerMessage, 'budget') !== false || strpos($lowerMessage, 'pay') !== false || strpos($lowerMessage, 'salary') !== false) {
            $responses = [
                "Budget optimization tip: Jobs with budgets above UGX 30,000 receive 40% more quality applications. Consider adjusting your rates to attract better candidates and improve your {$score}/100 performance score.",
                "Competitive budgets are key! Based on platform data, higher budgets (UGX 30,000+) significantly increase application quality. Your {$jobCount} jobs could benefit from budget optimization.",
                "Pay rate strategy: Offer competitive rates to attract skilled workers. Higher budgets not only get more applications but also better quality candidates who are serious about the work."
            ];
        }
        elseif (strpos($lowerMessage, 'view') !== false || strpos($lowerMessage, 'visibility') !== false) {
            $responses = [
                "Your jobs have received {$views} total views. To increase visibility: 1) Use specific job titles, 2) Add detailed descriptions, 3) Consider featured job upgrades for 5x more exposure.",
                "Visibility boost tips: Your {$jobCount} jobs have {$views} views. Try updating job titles with specific skills (e.g., 'Experienced Plumber' vs 'Worker'), and post during peak hours (9 AM - 5 PM).",
                "To improve your {$views} job views: Use relevant keywords in titles, specify exact location, and include skill requirements. Featured jobs get 5x more visibility!"
            ];
        }
        elseif (strpos($lowerMessage, 'score') !== false || strpos($lowerMessage, 'performance') !== false) {
            $responses = [
                "Your current performance score is {$score}/100. This is calculated based on job activity, application rates, and response times. To improve: post more jobs, respond quickly to applications, and maintain active listings.",
                "Performance analysis: {$score}/100 score based on your {$jobCount} jobs and {$applications} applications. Higher scores come from consistent posting, quick responses, and successful job completions.",
                "Score improvement strategy: Your {$score}/100 can be boosted by: 1) Posting 3+ active jobs, 2) Responding within 24 hours, 3) Using competitive budgets, 4) Completing jobs successfully."
            ];
        }
        elseif (strpos($lowerMessage, 'thank') !== false || strpos($lowerMessage, 'thanks') !== false) {
            $responses = [
                "You're very welcome! I'm always here to help you succeed with your hiring. Feel free to ask me anything about optimizing your job posts or improving your {$score}/100 performance score.",
                "Happy to help! Keep up the great work with your {$jobCount} active jobs. Remember, I'm here 24/7 to provide insights and recommendations for better hiring results.",
                "My pleasure! Your success is my priority. With {$applications} applications received so far, you're on the right track. Let me know if you need more specific advice!"
            ];
        }
        else {
            // General responses for other queries
            $responses = [
                "That's an interesting question! Based on your current data - {$jobCount} active jobs, {$applications} applications, and {$views} views - I can provide specific guidance. Could you be more specific about what you'd like to know?",
                "I understand you're looking for insights about '{$message}'. With your current performance score of {$score}/100, I can offer targeted advice. What specific aspect of hiring would you like to focus on?",
                "Great question! Your hiring activity shows {$jobCount} jobs and {$applications} applications. I can help with job optimization, candidate attraction, or performance improvement. What interests you most?",
                "I'm here to help with your hiring success! Currently, you have {$views} job views and {$applications} applications. Whether it's about posting better jobs, managing applications, or improving visibility, I've got insights for you.",
                "Thanks for reaching out! Based on your hiring data, I can provide personalized recommendations. Your {$jobCount} active jobs are performing at {$score}/100. What would you like to improve first?"
            ];
        }
        
        return $responses[array_rand($responses)];
    }
}