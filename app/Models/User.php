<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;


use App\Models\Subscription;
use App\Models\Assessment;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'gym_type', 'gym_equipment', 'employment_type'
    ];

    // protected $casts = [
    //     'gym_equipment' => 'array',
    // ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function fitnessAssessment()
    {
        return $this->hasOne(FitnessAssessment::class);
    }

    /**
     * Define the relationship with the PhysicalAssessment model.
     */
    public function physicalAssessment()
    {
        return $this->hasOne(PhysicalAssessment::class);
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gym_equipment' => 'array',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
