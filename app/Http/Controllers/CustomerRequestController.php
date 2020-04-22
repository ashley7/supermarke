<?php

namespace App\Http\Controllers;

use App\CustomerRequest;
use App\Customer;
use Illuminate\Http\Request;

class CustomerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_request = CustomerRequest::get();

        $data = [
            'customer_request' => $customer_request,
            'title' => 'Customer requests'
        ];

        return view('customer.customer_requests')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::get();

        $data = [
            'customers' => $customers,
            'title' => 'Customer request'
        ];

        return view('customer.create_customer_requests')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saveCustomerRequest = new CustomerRequest();
        $saveCustomerRequest->customer_id = $request->customer_id;
        $saveCustomerRequest->details = $request->details;
        try {
            $saveCustomerRequest->save();
        } catch (\Exception $e) {}

        return redirect()->route('customer_request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerRequest $customerRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($customerRequest)
    {
        $changeCustomerRequest = CustomerRequest::find($customerRequest);
        if ($changeCustomerRequest->status == "Not resolved") {
            $changeCustomerRequest->status = "Resolved";
            $changeCustomerRequest->save();
        }elseif ($changeCustomerRequest->status == "Resolved") {
            $changeCustomerRequest->status = "Not resolved";
            $changeCustomerRequest->save();
        }

        return redirect()->route('customer_request.index');
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerRequest $customerRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerRequest  $customerRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerRequest $customerRequest)
    {
        //
    }
}
