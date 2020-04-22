<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class CustomerRequest extends Model
{
    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
