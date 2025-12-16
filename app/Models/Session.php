<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'program_sessions';

    protected $fillable = [
        'program_id',
        'topic',
        'description',
        'facilitator',
        'location',
        'session_date',
        'duration_minutes',
        'status'
    ];

    protected $casts = [
        'session_date' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function isPast()
    {
        return $this->session_date < now();
    }

    public function isToday()
    {
        return $this->session_date->isToday();
    }
}
