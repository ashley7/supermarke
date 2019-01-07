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
        $price_tags = PriceTag::all();
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
            if (isset($request->client)) {
                $update_sales_shift->client = $request->client;
            }            
            $update_sales_shift->save();
        }

        $pricetag = PriceTag::all()->where('id',$request->data)->last();
        if (empty($pricetag)) {
            echo "The item price does not exist in the system";
            return;
        }else{
            SalesController::save_sale($pricetag->stock_id,$request->size,$pricetag,$request->workshift_id,$update_sales_shift->id,$request->discount); 

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
        return Sale::select('stocks.name as name','categories.name as category_name','amount','size','discount')->where('mainsales_id',$id)->join('stocks','sales.stock_id','stocks.id')->join('categories','stocks.category_id','categories.id')->get();
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
        $data = ['main_sale'=>$update_sales_shift];
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
