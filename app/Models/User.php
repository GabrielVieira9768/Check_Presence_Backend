<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'registration',
        'birth_date',
        'phone',
        'address',
        'role',
    ];

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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'role' => 'boolean',
    ];

    public function subjectsTaught()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'presence')
                    ->withPivot('status', 'date')
                    ->withTimestamps();
    }

    public function registeredSubjects()
    {
        return $this->belongsToMany(Subject::class, 'register')->withTimestamps()->withPivot('registered_at');
    }

}
