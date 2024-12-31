<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;

use Str;
use Kreait\Firebase\Auth;
use App\Models\User;

class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(Firebase $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            // Firebase Authentication
            $auth = Firebase::auth();

            // Create Firebase User
            $firebaseUser = $auth->createUser([
                'email' => $request->email,
                'password' => $request->password,
                'displayName' => $request->name,
            ]);

            // Save to your Laravel database
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_token' => Str::random(60), // Example API token
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'firebase_user' => $firebaseUser,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    // Register user using Firebase Authentication
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|confirmed',
    //         'gym_type' => 'nullable|string',
    //         'gym_equipment' => 'nullable|array',
    //         'employment_type' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     try {
    //         // Create user in Firebase
    //         $firebaseUser = Firebase::createUser([
    //             'email' => $request->email,
    //             'password' => $request->password,
    //             'displayName' => $request->name,
    //         ]);

    //         // Store the user in Laravel's database
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password), // Store hashed password
    //             'gym_type' => $request->gym_type,
    //             'gym_equipment' => json_encode($request->gym_equipment),
    //             'employment_type' => $request->employment_type,
    //             'api_token' => $firebaseUser->uid, // Use Firebase UID as API token
    //         ]);

    //         return response()->json([
    //             'message' => 'User registered successfully!',
    //             'user' => $user,
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Registration failed. Please try again.'], 500);
    //     }
    // }


     // Login user using Firebase Authentication
     public function login(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required|min:6',
         ]);

         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }

         try {
             // Verify user credentials with Firebase
             $firebaseAuth = app('firebase.auth');
             $signInResult = $firebaseAuth->signInWithEmailAndPassword($request->email, $request->password);

             // Fetch user record
             $firebaseUser = $signInResult->data();
             $firebaseUid = $firebaseUser['localId'];

             // Retrieve user from Laravel's database
             $user = User::where('email', $request->email)->first();
             if (!$user) {
                 return response()->json(['error' => 'User not found in the database.'], 404);
             }

             // Update API token with Firebase UID
             $user->api_token = $firebaseUid;
             $user->save();

             return response()->json([
                 'message' => 'Login successful!',
                 'user' => $user,
             ], 200);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Invalid credentials or login failed.'], 401);
         }

    }
     // Optional: Logout user (invalidate the token)
     public function logout(Request $request)
    {
         $user = $request->user();

         if (!$user) {
             return response()->json(['error' => 'User not authenticated.'], 401);
         }

         // Revoke the API token (optional, as Firebase tokens are session-based)
         $user->api_token = null;
         $user->save();
         return response()->json(['message' => 'User logged out successfully.'], 200);

    }

    public function userProfile(Request $request, $id)
    {
        $user = $request->user();

         if (!$user) {
             return response()->json(['error' => 'User not Found'], 401);
         }
         return response()->json(['message' => 'User Information Retrived successfully.', 'user'=>$user], 200);

    }


}
