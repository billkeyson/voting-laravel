<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['description','name','expiry_date','unit_cost','is_approved','user_id','event_type'];
    //

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function category(){
        return $this->hasOne('App\Category','event_id');
    }

    public function nominee(){
        return $this->hasOne('App\Nominee','event_id');
    }
}
