<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ParchasePayment;
use App\ParchaseDetails;
use App\Parchase;

class ParchasePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Parchase::all();
        $purchase = array();
        foreach ($purchases as $purchase_value) {
            if ($purchase_value->parchasedetails->count() == 0) {
                Parchase::destroy($purchase_value->id);
            }else{
                $purchase[] = Parchase::find($purchase_value->id);
            }
        }

        return view("purchases.all_purchases")->with(['purchase'=>$purchase]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_purchase_payment = new ParchasePayment($request->all());
        try {
            $save_purchase_payment->amount = str_replace(",","", $request->amount);
            $save_purchase_payment->save();

            $sum_amount = 0;

            $sum_deposited = ParchasePayment::where('parchase_id',$save_purchase_payment->parchase_id)->sum('amount');

            $purchase_cost = ParchaseDetails::where('parchase_id',$save_purchase_payment->parchase_id)->get();
            foreach ($purchase_cost as $purchase_value) {
                $sum_amount = $sum_amount + ($purchase_value->quantity * $purchase_value->unit_price);
            }

            if ( ($sum_amount-$sum_deposited) <= 0) {
                // update the status of the purchase
                $purchase = Parchase::find($save_purchase_payment->parchase_id);
                $purchase->status = 1;
                $purchase->save();
            }
           echo "Payment Saved";
        } catch (\Exception $e) {}
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
        //
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
