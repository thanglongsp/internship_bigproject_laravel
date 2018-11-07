<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model 
{ 
    use Searchable;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'name';
    }
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->only('name');

        // Customize array...

        return $array;
    }

    public function roads()
    {
        return $this->hasMany('App\Road');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('role');
    }

    public function requests(){
        return $this->hasMany('App\Request');
    }
}

