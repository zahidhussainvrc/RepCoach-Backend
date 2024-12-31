<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goals',
        'injury_history',
        'surgeries',
        'health_issues',
        'body_fat_goal',
        'body_weight_goal',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'goals' => 'array', // JSON casting for multiple goals
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
