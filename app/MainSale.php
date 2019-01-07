<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainSale extends Model
{
    public function sale()
    {
    	return $this->hasMany('App\Sale','mainsales_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function salespayment()
    {
    	return $this->hasMany("App\SalesPayment","mainsales_id");
    }
}
