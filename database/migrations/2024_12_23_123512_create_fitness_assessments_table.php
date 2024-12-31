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
        Schema::create('fitness_assessments', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('goals')->nullable(); // JSON to handle multiple goals
            $table->text('injury_history')->nullable();
            $table->text('surgeries')->nullable();
            $table->text('health_issues')->nullable();
            $table->integer('body_fat_goal')->nullable();
            $table->integer('body_weight_goal')->nullable();
            $table->timestamps();
       
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitness_assessments');
    }

};
