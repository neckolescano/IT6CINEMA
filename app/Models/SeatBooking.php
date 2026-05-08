<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    public $incrementing = false; 
    protected $fillable = ['booking_id', 'seat_id', 'price_locked'];

    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function seat() {
        return $this->belongsTo(Seat::class, 'seat_id');
    }
}
