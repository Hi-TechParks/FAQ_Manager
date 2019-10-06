<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    //

    public function faqs()
    {
    	return $this->hasMany('App\Faq', 'cateogry_id', 'id');
    }
}
