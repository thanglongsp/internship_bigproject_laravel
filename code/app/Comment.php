<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{	
	//protected $table = "comments";

    public function plan() 
    {
        return $this->belongsTo('App\Plan');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function parentComment() 
    {
        return $this->belongsTo('App\Comment','parent_id');
    }

    public function replies()
    {
        return $this->hasMany('App\Comment','parent_id'); 
    }
}

