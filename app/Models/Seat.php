<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    // Define the custom primary key from your ERD
    protected $primaryKey = 'seat_id';

    // Allow mass assignment
    protected $fillable = [
        'cinema_id',
        'seat_row',
        'seat_number',
    ];

    /**
     * A Seat belongs to a specific Cinema.
     */
    public function cinema(): BelongsTo
    {
        // Specifying 'cinema_id' as the foreign key
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }

    /**
     * A Seat can be associated with many seat bookings.
     */
    public function seatBookings(): HasMany
    {
        return $this->hasMany(SeatBooking::class, 'seat_id');
    }
}