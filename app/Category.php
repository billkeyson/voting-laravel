<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name','description','event_id']; 

    public function event(){
        return $this->belongsTo('App\Event','event_id');
    }
}
