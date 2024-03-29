<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //

    public function faqs()
    {
    	return $this->hasMany('App\Faq', 'location_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_locations', 
          'location_id', 'user_id');
    }
}
