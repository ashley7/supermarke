@extends('layouts.main')

@section('content')    
   
<a href="#" id="hide" onclick="myFunction()" style="float: right;" class="btn btn-success">Print</a>
<br><br>
<div class="card-box">
    <div class="card-body">
        <div class="row">        
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                <p style="text-transform: uppercase;">{{ config('app.name') }} (Buyer)</p>
                <p>Phone: +256 701 626 689 | +256 772 526 689</p>
                <p>Mukono - Uganda</p>
                <p>Transaction date: {{$purchase->created_at}}</p>
            </div>

            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                <p style="text-transform: uppercase;">{{$purchase->supplier->name}} (Saler)</p>
                <p>{{$purchase->supplier->phone_number}}</p>
                <p>{{$purchase->supplier->address}}</p>
            </div>
        </div>

        <p style="float: right; font-size: 20px; color: red;">No. {{$purchase->id}}</p>

        <center><h1><u>PURCHASE RECIEPT</u></h1></center>

        <div class="row">        
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <p style="text-transform: uppercase;">Particular</p>

                <table class="table table-hover table-striped">
                    <thead>
                      <th>#</th>  <th>Item</th> <th>Quantity</th> <th>Amount</th>
                    </thead>

                    <tbody>
                        <?php 
                         $total = 0;
                         ?>
                        @foreach($purchase->parchasedetails as $details)
                        <?php
                          $total = $total  + ($details->unit_price * $details->quantity);

                         ?>
                         <tr>
                            <td>{{$details->id}}</td>
                            <td>{{$details->stock->category->name}} ({{$details->stock->name}})</td>
                            <td>{{$details->quantity}} {{$details->stock->category->unit}} @ {{number_format($details->unit_price)}}</td>
                            <td>{{number_format($details->unit_price * $details->quantity)}}</td>                                        
                         </tr>
                        @endforeach

                        <tr>
                            <th>Total</th>  <th></th> <th></th> <th>{{number_format($total)}}</th>
                        </tr>
                    </tbody>
                </table>

                

                
            </div>

            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <p style="text-transform: uppercase;">Payments</p>

                 <table class="table table-hover table-striped">
                    <thead>
                       <th>Date</th> <th>Amount</th>
                    </thead>

                    <tbody>
                        <?php 
                         $payments_total = 0;
                         ?>
                        @foreach($purchase->parchasepayment as $details)
                        <?php
                          $payments_total = $payments_total  + ($details->amount);

                         ?>
                        <tr>
                             <td>{{$details->created_at}}</td>                                        
                            <td>{{number_format($details->amount)}}</td>
                        </tr>
                        @endforeach

                        <tr>
                            <th>Total</th>    <th>{{number_format($payments_total)}}</th>
                        </tr>
                    </tbody>
                </table>

                <p style="float: right; color: red; font-size: 20px;">Balance UGX: {{number_format($total - $payments_total)}}</p>

              <span id="exclude">
                <h3>Add Payment</h3>
                <input type="text" id="amount_paid" class="form-control">
                <input type="hidden" id="parchase_id" value="{{$purchase->id}}">
                <br>
                <button id="save_payments" class="btn btn-success">Save</button>
              </span>  
            </div>
        </div>
      </div>
    </div>

@endsection

@section('style')
  <style>
    @media print{
      #exclude,a,nav{
        display: none;      
     }

     #hide{
      display: none;
     }
    }

    .p{
      font-weight:  bold;
    }
 
  </style>
@endsection

@push('scripts')
  <script>
      $("#save_payments").click(function() {
            $("#save_payments").text("Processing ...");
            $("#save_payments").attr("disabled","disabled");
             $.ajax({
                    type: "POST",
                    url: "{{ route('purchase_payment.store') }}",
                data: {
                    amount: $("#amount_paid").val(),                              
                    parchase_id: $("#parchase_id").val(),                             
                    _token: "{{Session::token()}}"
                },
                    success: function(result){
                        $("#amount_paid").val(" ")
                        $("#save_payments").removeAttr("disabled");
                        $("#save_payments").text(result);
                        location.reload();
                }
            })
        });
  </script>


@endpush
 