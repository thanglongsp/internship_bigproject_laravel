<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    //
   	public function plan(){
   		return $this->belongsTo('App\Plan');
   	}

   	public function user(){
   		return $this->belongsTo('App\User');
   	}
}
