<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\Models\PhysicalAssessment;

use Illuminate\Http\Request;

class PhysicalAssessmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'stretch_score' => 'nullable|integer|min:1|max:10',
            'pain' => 'nullable|boolean',
            'post_stretch_score' => 'nullable|integer|min:1|max:10',
            'max_heart_rate' => 'nullable|integer',
            'recovery_time' => 'nullable|integer',
            'exercise_type' => 'nullable|string',
            'weight_used' => 'nullable|integer',
            'reps_completed' => 'nullable|integer',
        ]);

        $assessment = PhysicalAssessment::create($validated);

        return response()->json(['message' => 'Physical assessment recorded.', 'assessment' => $assessment], 201);
    }

}
