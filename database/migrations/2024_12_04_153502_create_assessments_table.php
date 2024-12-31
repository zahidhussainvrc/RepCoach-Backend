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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('stretch_score')->nullable();
            $table->boolean('pain')->default(false);
            $table->integer('post_stretch_score')->nullable();
            $table->integer('max_heart_rate')->nullable();
            $table->integer('recovery_time')->nullable();
            $table->string('exercise_type')->nullable();
            $table->integer('weight_used')->nullable();
            $table->integer('reps_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
