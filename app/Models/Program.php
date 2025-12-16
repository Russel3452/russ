<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'start_date',
        'end_date',
        'enrollment_deadline',
        'capacity',
        'enrolled_count',
        'status',
        'coordinator_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'enrollment_deadline' => 'date',
    ];

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function isEnrollmentOpen()
    {
        return $this->enrollment_deadline >= now()->toDateString() 
            && $this->enrolled_count < $this->capacity
            && $this->status === 'active';
    }

    public function isFull()
    {
        return $this->enrolled_count >= $this->capacity;
    }
}
