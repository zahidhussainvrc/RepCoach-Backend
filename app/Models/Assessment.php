<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'injury_history', 'surgery_history', 'health_issues', 'body_fat_goal', 'body_weight_goal'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
