<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Stock;
use App\Parchase;
use App\ParchaseDetails;
class ParchaseController extends Controller
{


    public function purchases_report()
    {
         return view("purchases.purchases_report");
    }

    public function purchasesreport(Request $request)
    {
        $purchase = ParchaseDetails::whereBetween('created_at',[$request->from,$request->to])->get();

        $title = "App purchases from ".$request->from." to ".$request->to;

        return view("purchases.purchases")->with(['purchase'=>$purchase,'title'=>$title]);
    }





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
            }
        }

        $purchase = ParchaseDetails::all();

        $title = "App purchases";

        return view("purchases.purchases")->with(['purchase'=>$purchase,'title'=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $initiate_purchase = new Parchase();
        $initiate_purchase->save();

        $data = ['suppliers'=>Supplier::all(),'stocks'=>Stock::all(),'purchase'=>$initiate_purchase];
        return view("purchases.add_purchanse")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_details = new ParchaseDetails($request->all());
        $save_details->unit_price = str_replace(",","", $request->unit_price);
        try {
            $save_details->save();

            $purchase = Parchase::find($save_details->parchase_id);
            $purchase->supplier_id = $request->supplier_id;
            $purchase->save();

            echo "Saved successfully";
        } catch (\Exception $e) {
            
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
        return ParchaseDetails::select('parchase_details.quantity as size','parchase_details.unit_price as amount','stocks.name as name','categories.name as category_name')->where('parchase_id',$id)->join('stocks','parchase_details.stock_id','stocks.id')->join('categories','stocks.category_id','categories.id')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Parchase::find($id);
        if (empty($purchase->supplier_id)) {
            return redirect()->route('purchases.create');
        }
        return view("purchases.purchanse_reciept")->with(['purchase'=>$purchase]);
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
