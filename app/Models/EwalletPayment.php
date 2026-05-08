<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EwalletPayment extends Model
{
    protected $primaryKey = 'payment_id';
    public $incrementing = false; 
    protected $fillable = ['payment_id', 'provider_name', 'reference_number'];

    public function payment() {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
}
