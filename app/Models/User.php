<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employment_type',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if user is superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('superadmin');
    }
    /**
     * Get user's work shifts
     */
    public function workShifts()
    {
        return $this->hasMany(WorkShift::class);
    }

    /**
     * Get user's currently active shift (if any)
     */
    public function activeShift()
    {
        return $this->workShifts()->where('status', 'open')->latest()->first();
    }
}
