<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //

    public function category()
    {
    	return $this->belongsTo('App\FaqCategory', 'category_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id');
    }
}
