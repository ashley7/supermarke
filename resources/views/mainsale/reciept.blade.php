@extends('layouts.main')

@section('content')
 
   <a href="#" onclick="myFunction()" style="float: right;" class="btn btn-primary">Print</a>
   <br><br>

  <div class="card-box">
      <div class="card-body">
          <div class="row">        
              <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <p style="text-transform: uppercase;">{{ config('app.name') }} (Saller)</p>
                  <p>Phone: +256 701 626 689 | +256 772 526 689</p>
                  <p>Mukono - Uganda</p>
                  <p>Transaction date: {{$main_sale->created_at}}</p>
              </div>

              <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <p style="text-transform: uppercase;">{{$main_sale->client}} (Buyer)</p>
              </div>
          </div>

          <p style="float: right; font-size: 20px; color: red;">No. {{$main_sale->id}}</p>

          <center><h1><u>SALES RECIEPT</u></h1></center>

          <div class="row">        
              <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <p style="text-transform: uppercase;">Particular</p>

                  <table class="table table-hover table-striped">
                      <thead>
                        <th>Item</th> <th>Quantity</th> <th>Discount</th> <th>Amount</th>
                      </thead>

                      <tbody>
                          <?php 
                           $total = $sum_discount = 0;
                           ?>
                          @foreach($main_sale->sale as $details)
                          <?php
                            $calculated_amount = ( ($details->amount * $details->size) - $details->discount);
                            $total = $total  + $calculated_amount;
                            $sum_discount = $sum_discount + $details->discount;
                           ?>
                           <tr>
                             
                              <td>{{$details->stock->category->name}} ({{$details->stock->name}})</td>
                              <td>{{$details->size}} {{$details->stock->category->unit}} @ {{number_format($details->amount)}}</td>
                              <td>{{number_format($details->discount)}}</td>
                              <td>{{number_format($calculated_amount)}}</td>                                        
                           </tr>
                          @endforeach

                          <tr>
                              <th>Total</th>  <th></th> <th> {{number_format($sum_discount)}} </th> <th>{{number_format($total)}}</th>
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
                          @foreach($main_sale->salespayment as $details)
                          <?php
                            $payments_total = $payments_total  + ($details->amount);

                           ?>
                          <tr>
                               <td>{{$details->created_at}}</td>                                        
                              <td>{{number_format($details->amount)}}</td>
                          </tr>
                          @endforeach

                          <tr>
                              <th>Total</th> <th>{{number_format($payments_total)}}</th>
                          </tr>
                      </tbody>
                  </table>

                  <p style="float: right; color: red; font-size: 20px;">Balance UGX: {{number_format($total - $payments_total)}}</p>

                <span class="exclude">
                  <label>Add Payment</label>
                  <input type="text" id="amount_paid" class="form-control">
                  <input type="hidden" id="mainsales_id" value="{{$main_sale->id}}">
                  <br>
                  <button id="save_payment">Save</button>
                </span>
              </div>
          </div>
      </div>
    </div>

                     
@endsection

@section('style')
  <style>
    @media print{
      .exclude,a,nav{
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
      $("#save_payment").click(function() {
            $("#save_payment").text("Processing ...");
            $("#save_payment").attr("disabled","disabled")
            $.ajax({
                type: "POST",
                url: "{{ route('sales_payment.store') }}",
            data: {
                amount: $("#amount_paid").val(),
                mainsales_id: $("#mainsales_id").val(),
                _token: "{{Session::token()}}"
            },
            success: function(result){
                $('#amount_paid').val(0);
                $("#save_payment").removeAttr("disabled");
                $("#save_payment").text(result);
                location.reload();
              }
          })           
        });
  </script>
@endpush
 