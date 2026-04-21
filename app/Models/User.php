<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * ERD COMPLIANCE: Use user_id as Primary Key
     */
    protected $primaryKey = 'user_id';

    /**
     * ERD COMPLIANCE: Attributes match the users table exactly
     */
    protected $fillable = [
        'email',
        'password',
        'role_id',
        'is_active', // Added from ERD
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
     * ERD COMPLIANCE: FK is role_id
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin()
    {
        // We use the relationship defined above to check role_name
        return $this->role && $this->role->role_name === 'admin';
    }

    /**
     * ERD COMPLIANCE: Relationship with admin_profile table
     */
    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class, 'user_id', 'user_id');
    }

    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class, 'user_id', 'user_id');
    }
}