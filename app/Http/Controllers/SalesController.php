<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use Carbon\Carbon;
use App\Stock;
use App\PriceTag;
use App\WorkShift;
use App\ShiftStock;
use App\SalesPayment;
use App\MainSale;
use App\Parchase;
use App\Http\Controllers\ParchaseController;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Sales";
        $sales = MainSale::all();
        foreach ($sales as $main_value) {
            if ($main_value->sale->count() == 0) {
                try {
                  MainSale::destroy($main_value->id);  
                } catch (\Exception $e) {}
                 
            }
            
        }         
        return view("sales.all_sales")->with(['main_sales'=>$sales,'title'=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_shift = WorkShift::all()->last();
        $title = "";
        $sum_sales = 0;
        $sum_tickets = 0;
        $main_sales = array();
        if (!empty($last_shift)) {
            $main_sales = MainSale::all()->where('workshift_id',$last_shift->id);
        }

        foreach ($main_sales as  $sales_details) {
            if ($sales_details->sale->count() == 0) {
                try {
                   MainSale::destroy($sales_details->id); 
                } catch (\Exception $e) {}
               
            }
            foreach ($sales_details->sale as $sales_value) {
               $sum_sales = $sum_sales + ( ($sales_value->amount * $sales_value->size) - $sales_value->discount); 
            }         
            $sum_tickets = $sum_tickets + 1;
        }

        
           // debit sales
            $debit_sales = $this->total_debit_sales();
            // credit purchase
            $credit_purchase = ParchaseController::total_credit_purchase();

            $total_sales_today = $this->total_sales();
            
            $data = ['sum_sales'=>$sum_sales,'sum_tickets'=>$sum_tickets,'main_sales'=>$main_sales,'debit_sales'=>$debit_sales,'credit_purchase'=>$credit_purchase,'total_sales_today'=>$total_sales_today];
            return view("sales.add_sales")->with($data);
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param  \Illuminate\Http\Request  $array of data in the form Nile special=5000
     * @return \Illuminate\Http\Response  A string
     */
    public function store(Request $request)
    {       
        $pricetag = PriceTag::all()->where('stock_id',$request->data)->last();
        if (empty($pricetag)) {
            echo "The barcode does not exist in the system";
            return;
        }else{
            // $this->save_sale($pricetag->stock_id,$request->data,$request->size,$pricetag,$request->workshift_id,$request->discount);

        }
    }


public static function save_sale($stock_id,$size,$pricetag,$workshift_id,$mainsales_id,$discount)
{
    $save_sale = new Sale();
    $save_sale->stock_id = $stock_id;
    $price = 0;
    $save_sale->date_sold = strtotime(date("Y-m-d"));
    $save_sale->size = $size;
    $save_sale->amount = $pricetag->salling_price;
    $save_sale->buying_price = $pricetag->buying_price;
    $save_sale->discount = str_replace(",", "", $discount);
    $save_sale->user_id = \Auth::user()->id;
    $save_sale->workshift_id = $workshift_id;
    $save_sale->mainsales_id = $mainsales_id;
    try {
        $save_sale->save();

        // reduce stock
        $record_check = ShiftStock::all()->where('stock_id',$stock_id)->where('workshift_id',$workshift_id)->last();
        if (!empty($record_check)) {
            $total_sold = Sale::all()->where('workshift_id',$workshift_id)->where('stock_id',$stock_id)->sum('size');
            $record_check->stock_left = ($record_check->old_stock + $record_check->new_stock) - $total_sold;
            $record_check->save();
        }

        // check stock limit
        $stock_check = Stock::find($stock_id);

        if ($record_check->stock_left <= $stock_check->keeping_limit) {
            echo "<span style='color:red'>".$stock_check->category->name." (".$stock_check->name.") is running out of stock, you have ".$record_check->stock_left." left</span>";
        }else{
            echo "Saved. ".$record_check->stock_left." left";
        }
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

    public static function total_debit_sales()
    {
        $all_sales = MainSale::all();
        $debit_sales = array();

        $total_balance = $payments_total = $total_sales = 0;
        
      
        foreach ($all_sales as $main_sale_value) {
            foreach ($main_sale_value->sale as $sales_value) {
               $total_sales = $total_sales + ( ($sales_value->amount * $sales_value->size) - $sales_value->discount); 
            }            
            $payments_total = $payments_total + $main_sale_value->salespayment->sum('amount');
        }
          
            $total_balance = ($total_sales - $payments_total);

            return $total_balance;
    }


    public static function total_sales()
    {
        $last_shift = WorkShift::all()->last();
        $main_sales = array();
        $total_sales = 0;
        if (!empty($last_shift)) {
            $main_sales = MainSale::all()->where('workshift_id',$last_shift->id);
        }
        foreach ($main_sales as  $sales_details) {
            $total_sales = $total_sales + $sales_details->salespayment->sum('amount');
        }

        return $total_sales;
    }
}
