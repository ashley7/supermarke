<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parchase extends Model
{
    public function supplier()
    {
    	return $this->belongsTo('App\Supplier','supplier_id');
    }

    public function parchasedetails()
    {
    	return $this->hasMany('App\ParchaseDetails');
    }

    public function parchasepayment()
    {
    	return $this->hasMany('App\ParchasePayment');
    }
}
