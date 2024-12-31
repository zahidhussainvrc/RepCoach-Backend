<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalAssessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'stretch_score',
        'pain',
        'post_stretch_score',
        'max_heart_rate',
        'recovery_time',
        'exercise_type',
        'weight_used',
        'reps_completed',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
