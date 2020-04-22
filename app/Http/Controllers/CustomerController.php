<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MainSale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::get();

        $data = [
            'customers'=>$customer,
            'title' => 'Customers'
        ];

        return view("customer.customers")->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'title' => 'Create customer'
        ];
        return view("customer.create_customer")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkCustomer = Customer::where('phone_number',$request->phone_number)->get();

        $saveCustomer = new Customer();
        $saveCustomer->name = $request->name;
        $saveCustomer->address = $request->address;
        $saveCustomer->phone_number = $request->phone_number;

        if ($checkCustomer->count() == 0) {
            try {            
                $saveCustomer->save();
                echo "Saved successfully";
            } catch (\Exception $e) {}

        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer)
    {
       
        $mainSales = MainSale::where('customer_id',$customer)->get();   

        $customer = Customer::find($customer);   

        $title = "Transactions by ".$customer->name; 
            
        return view("sales.all_sales")->with(['main_sales'=>$mainSales,'title'=>$title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
