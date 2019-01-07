<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Category;

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
        return view('sales.stock_list')->with(['stock'=>$stock,'title'=>'All the stock']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.stock')->with(['category'=>Category::orderBy('name','ASC')->get()]);
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
        $data = ['read_stock'=>Stock::find($id)];
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
            echo "Updated Successfully";
        } catch (\Exception $e) {}

        return redirect()->route("stock.index");
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
