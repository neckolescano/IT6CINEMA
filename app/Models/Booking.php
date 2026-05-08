<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $fillable = ['customer_id', 'schedule_id', 'total_amount', 'status', 'booking_time'];

    public function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'booking_id');
    }
}
