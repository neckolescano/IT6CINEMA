<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $table = 'customer_profiles'; // Match the plural name in ERD
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}