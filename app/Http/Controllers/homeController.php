<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class homeController extends Controller
{
    /**
     * Display the home page with featured jobs
     */
    public function home()
    {
        // Get featured/latest jobs (active jobs, ordered by created_at)
        $featuredJobs = Job::where('status', 'active')
            ->with(['employer', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        // Get job statistics
        $stats = [
            'total_jobs' => Job::where('status', 'active')->count(),
            'total_employers' => \App\Models\User::where('role', 'employer')->count(),
            'total_workers' => \App\Models\User::where('role', 'worker')->count(),
        ];
        
        return view('files.home', compact('featuredJobs', 'stats'));
    }
}
