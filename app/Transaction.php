<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   
      
    protected $fillable = 
    [
        'amount',
        'reference',
        'nominee_id',
        'status',
        'payment_channel',
        'payment_method',
        'customer_mobile',
        'event_id',
        'currency',
        'paid_at'
    ];
}
