<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UssdTemplate extends Model
{
    protected $fillable = ['event_id','user_id','options','default_value','name','description','input_type','order_in_variable'];
    //
}
