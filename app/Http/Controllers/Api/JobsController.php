<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Get job details by ID
     */
    public function show($id)
    {
        try {
            $job = Job::with(['employer', 'category', 'skillsRequired', 'applications.user'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'description' => $job->description,
                    'location' => $job->location,
                    'budget' => $job->budget,
                    'job_type' => $job->job_type,
                    'status' => $job->status,
                    'is_urgent' => $job->is_urgent ?? false,
                    'required_skills' => $job->required_skills,
                    'experience_level' => $job->experience_level ?? null,
                    'duration' => $job->duration,
                    'created_at' => $job->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $job->updated_at->format('Y-m-d H:i:s'),
                    'employer' => [
                        'id' => $job->employer->id,
                        'name' => $job->employer->name,
                        'email' => $job->employer->email,
                        'company_name' => $job->employer->company_name ?? null,
                    ],
                    'category' => $job->category ? [
                        'id' => $job->category->id,
                        'name' => $job->category->name,
                    ] : null,
                    'skills' => $job->skillsRequired->map(function($skill) {
                        return [
                            'id' => $skill->id,
                            'name' => $skill->name,
                        ];
                    }),
                    'applications_count' => $job->applications->count(),
                    'applications' => $job->applications->map(function($application) {
                        return [
                            'id' => $application->id,
                            'status' => $application->status,
                            'applied_at' => $application->created_at->format('Y-m-d H:i:s'),
                            'user' => [
                                'id' => $application->user->id,
                                'name' => $application->user->name,
                                'email' => $application->user->email,
                            ],
                        ];
                    }),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found or error fetching job details',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get all jobs with optional filters
     */
    public function index(Request $request)
    {
        try {
            $query = Job::with(['employer', 'category']);

            // Apply filters
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('employer_id')) {
                $query->where('employer_id', $request->employer_id);
            }

            $jobs = $query->orderBy('created_at', 'desc')->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $jobs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching jobs',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
