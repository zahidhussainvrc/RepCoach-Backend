<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FitnessAssessment;
class FitnessAssessmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'goals' => 'nullable|array',
            'injury_history' => 'nullable|string',
            'surgeries' => 'nullable|string',
            'health_issues' => 'nullable|string',
            'body_fat_goal' => 'nullable|integer|min:0|max:100',
            'body_weight_goal' => 'nullable|integer',
        ]);

        $assessment = FitnessAssessment::create($validated);

        return response()->json(['message' => 'Fitness assessment recorded.', 'assessment' => $assessment], 201);
    }

}
