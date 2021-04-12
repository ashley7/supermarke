<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdhocReport extends Model
{
    public static function quantitySold($from,$to,$stock_id)
    {

    	$sum_size = Sale::where('stock_id',$stock_id)->whereBetween('created_at',[$from,$to])->sum('size');

    	$norhern = (80/100) * $sum_size;

    	return (int)$norhern;
    	 
    }

    public static function discounts($from,$to,$stock_id)
    {

    	return Sale::where('stock_id',$stock_id)->whereBetween('created_at',[$from,$to])->sum('discount');
    	 
    }

    public static function amount($from,$to,$stock_id)
    {

    	$amount = 0;

    	$sales = Sale::where('stock_id',$stock_id)->whereBetween('created_at',[$from,$to])->get();

    	foreach ($sales as $sale) {

    		$amount = $amount + (($sale->amount *   (int) ( (80/100) * $sale->size)   ) - $sale->discount );
    		 
    	}

    	return $amount;
    	 
    }
}
