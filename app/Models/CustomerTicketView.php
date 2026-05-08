<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTicketView extends Model
{
    // Important: Tell Laravel the view name
    protected $table = 'vw_customer_tickets';
    
    // Views are read-only usually, so disable timestamps
    public $timestamps = false;
}