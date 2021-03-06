<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	public function sales()
	{
		return $this->hasMany('App\Sale');
	}

	public function priceTag()
	{
		return $this->hasOne('App\PriceTag');
	}

}
