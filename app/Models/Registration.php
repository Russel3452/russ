<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'health_goals',
        'personal_notes',
        'status',
        'withdrawal_reason',
        'registered_at'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function progressMetrics()
    {
        return $this->hasMany(ProgressMetric::class);
    }
}
