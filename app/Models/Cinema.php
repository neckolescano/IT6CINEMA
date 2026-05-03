<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    // Define the custom primary key from your ERD
    protected $primaryKey = 'cinema_id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'cinema_name',
        'capacity',
    ];

    /**
     * A Cinema contains many Seats.
     */
    public function seats(): HasMany
    {
        // We specify 'cinema_id' as the foreign key in the seats table
        return $this->hasMany(Seat::class, 'cinema_id');
    }

    /**
     * A Cinema hosts many Schedules.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'cinema_id');
    }
}