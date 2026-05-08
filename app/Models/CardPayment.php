<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{
    protected $primaryKey = 'payment_id';
    public $incrementing = false; 
    protected $fillable = ['payment_id', 'card_network', 'authorization_code'];

    public function payment() {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
}
