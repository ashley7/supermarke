<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParchaseDetails extends Model
{
    protected $fillable = ['parchase_id','stock_id','quantity'];

    public function stock()
    {
    	return $this->belongsTo('App\Stock');
    }

    public function parchase()
    {
    	return $this->belongsTo('App\Parchase','parchase_id');
    }
}
