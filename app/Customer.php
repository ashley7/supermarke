<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MainSale;
use App\Customer;

class Customer extends Model
{
    public static function customerSale($main_sale_id)
    {
    	$read_sales = MainSale::find($main_sale_id);

    	if (empty($read_sales->customer_id)) {
    		return [];
    	}else{
    		return Customer::where('id',$read_sales->customer_id)->get()->last();
    	}     
    	
    }
}
