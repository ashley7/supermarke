<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SalesController;
use App\WorkShift;
use App\MainSale;
use App\PriceTag;
use App\Sale;

class MainSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $price_tags = PriceTag::orderBy('name','ASC')->get();
        $initiate_sale = new MainSale();
        $initiate_sale->sales_number = time() + \Auth::user()->id;
        $initiate_sale->user_id = \Auth::user()->id;
        $initiate_sale->period_recorded = time();
        $initiate_sale->save();
        $shift = WorkShift::where('user_id',\Auth::user()->id)->orderBy('id','DESC')->get();
        $data = ["initiate_sale"=>$initiate_sale,"shift"=>$shift,"price_tags"=>$price_tags];
        return view("mainsale.start_sale")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $update_sales_shift = MainSale::find($request->mainsales_id);
        if (empty($update_sales_shift->workshift_id)) {
            $update_sales_shift->workshift_id = $request->workshift_id;
            $update_sales_shift->save();
        }

        $pricetag = PriceTag::all()->where('barcode',$request->data)->last();
        if (empty($pricetag)) {
            echo "The barcode does not exist in the system";
            return;
        }else{
            SalesController::save_sale($pricetag->name,$request->class_price,$request->data,$request->size,$pricetag,$request->workshift_id,$update_sales_shift->id);    
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $read_sales_on_reciept = Sale::where('mainsales_id',$id)->get();
        return $read_sales_on_reciept;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $update_sales_shift = MainSale::find($id);
        $data = ['update_sales_shift'=>$update_sales_shift];
        return view("mainsale.reciept")->with($data);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
