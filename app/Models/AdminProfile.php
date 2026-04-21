<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    // 1. Tell Laravel the exact table name from your ERD
    protected $table = 'admin_profile';

    // 2. Tell Laravel the exact Primary Key
    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name'
    ];

    // Relationship: Profile belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}