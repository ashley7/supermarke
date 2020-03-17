<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceTag extends Model
{
    protected $fillable = ['buying_price','barcode','salling_price','stock_id'];

    public function stock()
    {
    	return $this->belongsTo('App\Stock');
    }
}
