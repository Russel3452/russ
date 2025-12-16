<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'health_conditions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function coordinatedPrograms()
    {
        return $this->hasMany(Program::class, 'coordinator_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function isParticipant()
    {
        return $this->role === 'participant';
    }

    public function isCoordinator()
    {
        return $this->role === 'coordinator';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
