<?php

use App\Http\Controllers\api\AuthController;
// use App\Http\Controllers\api\OnboardingController;
use App\Http\Controllers\api\OnboardingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'auth'], function () {

    Route::get('test', function(){
        return "Api Testing";

    });

    Route::post('register', [AuthController::class, 'register']);

    Route::post('login', [AuthController::class, 'login']);
    Route::post('sociallogin', [AuthController::class, 'socialLogin']);
    // Route::post('logout', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');


    Route::post('send-otp', [AuthController::class, 'sendOtp']);

    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']); // Forgot Password route
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

});


Route::group(['prefix' => 'user'], function () {

    Route::middleware('auth:api')->group(function () {

        Route::controller(AuthController::class)->group(function(){

            Route::post('/user-profile', 'userProfile');
        });


        Route::controller(OnboardingController::class)->group(function(){

            Route::post('/onboarding/personal-info', 'storePersonalInfo');
        });


    });

});
