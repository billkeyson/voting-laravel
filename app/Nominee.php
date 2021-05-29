<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    //
    protected $fillable = ['name','bio','event_id','cat_id'];
}
