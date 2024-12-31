<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id(); // Primary Key
            $table->string('name'); // Full Name
            $table->string('email')->unique(); // Email Address (Unique)
            $table->string('password'); // User Password

            // Onboarding Fields
            $table->string('gym_type')->nullable(); // Gym Type (e.g., Home, Big Gym, etc.)
            $table->json('gym_equipment')->nullable(); // Equipment (Stored as JSON)
            $table->string('employment_type')->nullable(); // Employment Type (e.g., Standing, Sitting)
            $table->string('job_title')->nullable(); // Job Title (Optional)
            $table->date('date_joined')->nullable(); // Onboarding Date (Optional)
            $table->integer('workout_duration')->nullable(); // Workout Duration (in minutes)
            $table->integer('training_frequency')->nullable(); // Training Frequency (days per week)

            // API and User Management
            $table->string('api_token')->nullable(); // API Token for authentication
            $table->string('type')->default('user'); // User Type (Default: 'user')
            $table->boolean('is_active')->default(true); // Active Status (Default: true)
            $table->timestamp('expiry_time')->nullable(); // Account Expiry Time (Optional)

            // Timestamps
            $table->timestamps();

            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
