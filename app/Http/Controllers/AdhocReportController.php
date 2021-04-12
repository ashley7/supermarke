<?php

namespace App\Http\Controllers;

use App\AdhocReport;
use App\Stock;
use Illuminate\Http\Request;

class AdhocReportController extends Controller
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
    
        $data = [
            'title' => 'Select date ranges'
        ];

        return view('report.select_date_ranges')->with($data);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $stock = Stock::get();

        $from = $request->from;

        $to = $request->to;

        $data = [

            'stocks' => $stock,

            'from' => $from,

            'to' => $to,

            'title' => 'Transactions from '.$from.' to '.$to

        ];

        return view('report.stock_sales')->with($data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AdhocReport  $adhocReport
     * @return \Illuminate\Http\Response
     */
    public function show(AdhocReport $adhocReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdhocReport  $adhocReport
     * @return \Illuminate\Http\Response
     */
    public function edit(AdhocReport $adhocReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdhocReport  $adhocReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdhocReport $adhocReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdhocReport  $adhocReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdhocReport $adhocReport)
    {
        //
    }
}
