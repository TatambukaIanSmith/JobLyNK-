<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    /**
     * Display a listing of jobs with search and filtering
     */
    public function jobs(Request $request)
    {
        $query = Job::with(['employer', 'category'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('location', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        // Job type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // Budget range filter
        if ($request->filled('min_budget')) {
            $query->where('budget', '>=', $request->min_budget);
        }
        if ($request->filled('max_budget')) {
            $query->where('budget', '<=', $request->max_budget);
        }

        // Urgency filter
        if ($request->filled('urgent_only')) {
            $query->where('is_urgent', true);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        switch ($sortBy) {
            case 'budget':
                $query->orderBy('budget', $sortOrder);
                break;
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            case 'location':
                $query->orderBy('location', $sortOrder);
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
        }

        // Paginate results
        $jobs = $query->paginate(12)->withQueryString();

        // Get categories for filter dropdown
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        // Get unique locations for filter
        $locations = Job::where('status', 'active')
            ->select('location')
            ->distinct()
            ->whereNotNull('location')
            ->orderBy('location')
            ->pluck('location');

        // Get job statistics
        $stats = [
            'total_jobs' => Job::where('status', 'active')->count(),
            'urgent_jobs' => Job::where('status', 'active')->where('is_urgent', true)->count(),
            'categories_count' => $categories->count(),
        ];

        return view('files.jobs', compact('jobs', 'categories', 'locations', 'stats'));
    }

    /**
     * Display a specific job posting
     */
    public function show(Job $job)
    {
        // Increment view count
        $job->increment('views');

        // Check if current user has applied
        $hasApplied = false;
        if (Auth::check() && Auth::user()->isWorker()) {
            $hasApplied = Application::where('job_id', $job->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        // Get related jobs
        $relatedJobs = Job::where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->where('status', 'active')
            ->limit(3)
            ->get();

        return view('files.job-detail', compact('job', 'hasApplied', 'relatedJobs'));
    }

    /**
     * Apply for a job
     */
    public function apply(Request $request, Job $job)
    {
        // Check if user is authenticated and is a worker
        if (!Auth::check() || !Auth::user()->isWorker()) {
            return redirect()->route('login')->with('error', 'Please login as a worker to apply for jobs.');
        }

        // Check if job is still active
        if (!$job->isActive()) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        // Check if user has already applied
        $existingApplication = Application::where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this job.');
        }

        // Validate application data
        $validated = $request->validate([
            'cover_letter' => ['required', 'string', 'max:1000'],
            'proposed_rate' => ['nullable', 'numeric', 'min:0'],
        ], [
            'cover_letter.required' => 'Please provide a cover letter explaining why you\'re suitable for this job.',
            'cover_letter.max' => 'Cover letter must not exceed 1000 characters.',
            'proposed_rate.numeric' => 'Proposed rate must be a valid number.',
        ]);

        // Create application
        $application = Application::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'cover_letter' => $validated['cover_letter'],
            'proposed_rate' => $validated['proposed_rate'] ?? null,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        // Increment applications count
        $job->increment('applications_count');

        return back()->with('success', 'Your application has been submitted successfully! The employer will review it and get back to you.');
    }

    /**
     * Save/bookmark a job
     */
    public function bookmark(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to bookmark jobs.'], 401);
        }

        $user = Auth::user();
        
        // Toggle bookmark
        $bookmarks = $user->bookmarked_jobs ?? [];
        
        if (in_array($job->id, $bookmarks)) {
            // Remove bookmark
            $bookmarks = array_filter($bookmarks, fn($id) => $id != $job->id);
            $message = 'Job removed from bookmarks.';
            $bookmarked = false;
        } else {
            // Add bookmark
            $bookmarks[] = $job->id;
            $message = 'Job bookmarked successfully!';
            $bookmarked = true;
        }

        $user->bookmarked_jobs = array_values($bookmarks);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => $message,
            'bookmarked' => $bookmarked
        ]);
    }

    /**
     * Get job search suggestions
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Job::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('location', 'LIKE', "%{$query}%");
            })
            ->select('title', 'location')
            ->distinct()
            ->limit(10)
            ->get()
            ->map(function($job) {
                return [
                    'title' => $job->title,
                    'location' => $job->location,
                ];
            });

        return response()->json($suggestions);
    }

    /**
     * Search jobs for live search results
     */
    public function search(Request $request)
    {
        $query = $request->get('q', $request->get('search', ''));
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $jobs = Job::with('employer')
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('location', 'LIKE', "%{$query}%")
                  ->orWhere('required_skills', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company_name' => $job->employer->name ?? 'Company',
                    'location' => $job->location,
                    'salary' => $job->budget,
                    'job_type' => $job->job_type,
                    'is_urgent' => $job->is_urgent ?? false,
                ];
            });

        return response()->json($jobs);
    }
}
