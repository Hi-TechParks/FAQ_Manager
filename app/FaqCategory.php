<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    //

    public function faqs()
    {
    	return $this->hasMany('App\Faq', 'category_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_categories', 
          'category_id', 'user_id');
    }
}
