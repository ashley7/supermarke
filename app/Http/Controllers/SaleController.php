<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Stock;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $readStock = Stock::get();

        $data = [

            'title' => 'Stock sales report',

            'stocks' => $readStock

        ];

        return view('report.stock_sales_report')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [

            'from' => 'required',
            'to' => 'required',
            'stock_id' => 'required'

        ];

        $this->validate($request,$rules);

        $stock = Stock::whereIn('id',$request->stock_id)->get();

        $to = $request->to;

        $from = $request->from;

        $data = [
            'stockItems' => $stock,
            'from' => $from,
            'to' => $to,
            'title' => 'Stock sales from '.$from." to ".$to,
        ];

        return view('report.sales_report')->with($data);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
