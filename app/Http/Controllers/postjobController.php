<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class postjobController extends Controller
{
    /**
     * Display the job posting form.
     */
    public function postjob()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('files.postjob', compact('categories'));
    }

    /**
     * Store a newly created job posting.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'jobTitle' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'description' => ['required', 'string', 'min:20'],
            'location' => ['required', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'jobType' => ['required', 'string', Rule::in(['one-time', 'recurring', 'project'])],
            'paymentType' => ['required', 'string', Rule::in(['hourly', 'fixed', 'negotiable'])],
            'budget' => ['required', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:255'],
            'startDate' => ['required', 'date', 'after_or_equal:today'],
            'urgency' => ['required', 'string', Rule::in(['normal', 'urgent', 'asap'])],
            'skills' => ['nullable', 'string'],
            'job_skills' => ['nullable', 'string'], // New skills data
        ]);

        try {
            \DB::beginTransaction();

            // Create location string
            $location = $validated['location'];
            if (!empty($validated['district'])) {
                $location = $validated['location'] . ', ' . $validated['district'];
            }

            // Get or create category
            $category = Category::where('slug', $validated['category'])->first();
            
            if (!$category) {
                // If category doesn't exist, create it
                $category = Category::create([
                    'name' => ucfirst(str_replace('-', ' ', $validated['category'])),
                    'slug' => $validated['category'],
                    'description' => 'Auto-created category',
                    'is_active' => true
                ]);
            }

            // Create the job posting
            $job = Job::create([
                'user_id' => Auth::id(),
                'category_id' => $category->id,
                'title' => $validated['jobTitle'],
                'description' => $validated['description'],
                'location' => $location,
                'job_type' => $validated['jobType'],
                'payment_type' => $validated['paymentType'],
                'budget' => $validated['budget'],
                'duration' => $validated['duration'] ?? null,
                'start_date' => $validated['startDate'],
                'urgency' => $validated['urgency'],
                'required_skills' => $validated['skills'] ?? '',
                'is_featured' => false,
                'is_urgent' => $validated['urgency'] !== 'normal',
                'requires_background_check' => false,
                'status' => 'active', // Make jobs active immediately for now
                'views' => 0,
                'applications_count' => 0,
            ]);

            // Handle new skills system
            if (!empty($validated['job_skills'])) {
                $jobSkills = json_decode($validated['job_skills'], true);
                
                if (is_array($jobSkills)) {
                    foreach ($jobSkills as $skillData) {
                        \App\Models\JobSkill::create([
                            'job_id' => $job->id,
                            'skill_id' => $skillData['skill_id'],
                            'required_level' => $skillData['required_level'] ?? 'Beginner',
                            'is_required' => $skillData['is_required'] ?? true
                        ]);
                    }
                }
            }

            \DB::commit();

            // Create job notifications for matching workers
            $matchingService = app(\App\Services\JobMatchingService::class);
            $matchingService->createJobNotifications($job);

            // Redirect back to dashboard with success message
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Job "' . $job->title . '" posted successfully!',
                    'job' => $job
                ]);
            }

            return redirect()->route('employerDashboard')
                ->with('success', 'Job "' . $job->title . '" posted successfully! It is now live and visible to workers.');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating job posting', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating job posting: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error creating job posting. Please try again.'])->withInput();
        }
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
