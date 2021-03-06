<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Category;
use App\WorkShift;
use App\ShiftStock;
use App\PriceTag;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = Stock::all();       
        return view('sales.stock_list')->with(['stock'=>$stock,'title'=>'Current stock status']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.stock')->with(['category'=>Category::orderBy('name','ASC')->get(),'title'=>'Add new stock']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_stock = new Stock();
        $save_stock->category_id = $request->category_id;
        $save_stock->name = $request->item_name;
        $save_stock->keeping_limit = $request->keeping_limit;
        try {
            $save_stock->save();
            // update stock
            $work_shift = WorkShift::all()->last();

            $record_check = ShiftStock::all()->where('stock_id',$save_stock->id)->where('workshift_id',$work_shift->id);

            $savestock = new ShiftStock();
            $savestock->stock_id = $save_stock->id;
            $savestock->workshift_id = $work_shift->id;
            $savestock->user_id = \Auth::user()->id;

            if ($record_check->count() == 0) {
                $savestock->old_stock = $request->stock_size;
                $savestock->save();
            }else{
                $last_record = $record_check->last();
                $last_record->new_stock = ($last_record->new_stock + $request->stock_size);
                $last_record->save();
            }

            $save_tags = new PriceTag();

            if (!isset($request->barcode)) {
               $save_tags->barcode = time();
               }else{
                 $save_tags->barcode = $request->barcode;
            }

            $save_tags->barcode = time();
            $save_tags->stock_id = $save_stock->id;
            $save_tags->buying_price = str_replace(",","",$request->buying_price);
            $save_tags->salling_price = str_replace(",","",$request->selling_price);
            $save_tags->save();
            echo "Saved Successfully";
        } catch (\Exception $e) {
            echo $e->getMessage();
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
        $data = [
            'stock'=>Stock::all(),
            'title'=>'All stock items'
        ];

        return view('sales.stock_list_only')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $saling_price = $buying_price = 0;
       

        $price_tag = PriceTag::all()->where('stock_id',$id)->last();

        if (!empty($price_tag)) {
            $saling_price = $price_tag->salling_price;
            $buying_price = $price_tag->buying_price;
        }

         $data = [
            'read_stock'=>Stock::find($id),
            'title'=>'Edit stock',
            'buying_price'=>$buying_price,
            'saling_price'=>$saling_price,
        ];

        return view('sales.edit_stock')->with($data);
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
        $save_stock = Stock::find($id);
        $save_stock->name = $request->item_name;
        $save_stock->keeping_limit = $request->keeping_limit;
         try {
            $save_stock->save();

            $price_tag = PriceTag::all()->where('stock_id',$id)->last();
            $price_tag->salling_price = $request->saling_price;
            $price_tag->buying_price = $request->buying_price;

            $price_tag->save();

            return redirect()->back()->with(['status'=>'Updated Successfully']);
            
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

       
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
