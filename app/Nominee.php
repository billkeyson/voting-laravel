<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    //
    protected $fillable = ['name','bio','event_id','cat_id'];

    public function category(){
        return $this->belongsTo('App\Category','cat_id');
    }

    public function event(){
        return $this->belongsTo('App\Event','event_id');
    }
}
