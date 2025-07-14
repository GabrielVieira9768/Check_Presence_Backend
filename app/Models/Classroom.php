<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'code',
        'subject_id',
        'date',
        'location',
        'start_time',
        'end_time',
        'password',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    // Outros relacionamentos, ex:
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
