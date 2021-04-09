<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function stock()
    {
    	return $this->belongsTo('App\Stock');
    }

    public function mainsale()
    {
    	return $this->belongsTo('App\MainSale');
    }

   
}
