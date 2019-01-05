<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PriceTag;
use App\Stock;

class PriceTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $price_tags = PriceTag::all();
        $title = "List of price tags";
        return view('sales.pricetag_list')->with(['price_tags'=>$price_tags,'title'=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_stock = Stock::all();
        $stock = array();
        foreach ($all_stock as $stock_value) {
            if (PriceTag::where('stock_id',$stock_value->id)->count() == 0) {
                $stock[] = Stock::find($stock_value->id);
            }
        }
        return view('sales.price_tags')->with(['stock'=>$stock]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_tags = new PriceTag($request->all());
        $save_tags->barcode = time();
        $save_tags->buying_price = str_replace(",","",$request->buying_price);
        $save_tags->salling_price = str_replace(",","",$request->salling_price);

         $status = "";
      
        try {
            $save_tags->save();
            $status = "Saved successfully";
        } catch (\Exception $e) {}
        return back()->with(['status'=>$status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $read_tags = PriceTag::find($id);
        return view('sales.pricetag_edit')->with(['read_tags'=>$read_tags]);
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
        $status = "";
        try {
            $save_tags = PriceTag::find($id);
            $save_tags->buying_price = str_replace(",","",$request->buying_price);
            $save_tags->salling_price = str_replace(",","",$request->salling_price);
            $save_tags->save();
            $status="Saved successfully";
        } catch (\Exception $e) {
         }
        return redirect()->route('price_tag.index')->with(['status'=>$status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PriceTag::destroy($id);
        return back();
    }
}
