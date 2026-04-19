<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Get all available skills
     */
    public function index()
    {
        $skills = Skill::active()
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return response()->json($skills);
    }

    /**
     * Get skills by category
     */
    public function byCategory($category)
    {
        $skills = Skill::active()
            ->where('category', $category)
            ->orderBy('name')
            ->get();

        return response()->json($skills);
    }

    /**
     * Search skills
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $skills = Skill::active()
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%{$query}%")
                           ->orWhere('category', 'like', "%{$query}%")
                           ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->limit(50)
            ->get();

        return response()->json($skills);
    }

    /**
     * Create a new skill
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:skills,name',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        try {
            $skill = Skill::create([
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                'is_active' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Skill created successfully',
                'skill' => $skill
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating skill: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all job categories
     */
    public function jobCategories()
    {
        $categories = JobCategory::active()
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    /**
     * Get skill categories
     */
    public function skillCategories()
    {
        $categories = Skill::active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return response()->json($categories);
    }
}