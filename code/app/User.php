<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //
    protected $fillable = ['name', 'email', 'password'];
    //protected $table = "users";

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function plans() 
    {
        return $this->belongsToMany('App\Plan')->withPivot('role');
    }
}

