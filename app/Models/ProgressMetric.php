<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'metric_type',
        'metric_value',
        'unit',
        'recorded_date',
        'notes',
        'recorded_by'
    ];

    protected $casts = [
        'recorded_date' => 'date',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
