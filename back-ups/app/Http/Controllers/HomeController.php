<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PriceTag;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
	   	return redirect()->route('sales.create');
    }

    public function price_tags(Request $request)
    {
    	$pricetag = PriceTag::all()->where('id',$request->data)->last();
    	if (empty($pricetag)) {
    		echo "The item you selected is not having price.";
    		return;
    	}else{
    		echo "
    		<table class='table'>
    		<tr> <td> Name</td> <td style='text-transform:uppercase;'>".$pricetag->stock->category->name."(".$pricetag->stock->name.")</td></tr>".
    		 "<tr> <td>Price</td> <td>UGX ".number_format($pricetag->salling_price)."</td></tr>    		 
    		 </table>
    		";
    	}
    }
}