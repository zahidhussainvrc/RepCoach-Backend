<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;


class OnboardingController extends Controller
{
    public function storePersonalInfo(Request $request)
    {
        // return "testing";


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'gym_type' => 'required|string',
            'gym_equipment' => 'nullable|array',
            'employment_type' => 'required|string',
            'job_title' => 'nullable|string',
            'training_frequency' => 'required|string',
            'workout_duration' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gym_type' => $request->gym_type,
            'gym_equipment' => json_encode($request->gym_equipment),
            'employment_type' => $request->employment_type,
            'job_title' => $request->job_title,
            'training_frequency' => $request->training_frequency,
            'workout_duration' => $request->workout_duration,
            'date_joined' => $user->date_joined ?? now(), // Auto-generated
        ]);

        return response()->json([
            'message' => 'Onboarding information saved successfully.',
            'user' => $user,
        ], 200);
    }
}
