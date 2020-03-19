@extends('layouts.main')

@section('content')
 
                          
        <a  href="{{route('main_sale.create')}}"  class="btn btn-success">Record Sales</a> 
        <a  href="{{route('work_shifts.create')}}"  class="btn btn-success">+ New shift</a>
        <!-- <a  href="{{route('price_tag.create')}}" class="btn btn-success">+ Price tags</a>  -->
        <a  href="{{route('sales.index')}}"  class="btn btn-success" style="color: #FFF">View Sales</a>
        <a  href="{{route('stock_loss.create')}}"  class="btn btn-success" style="color: #FFF">Record Stock loss</a>        
        <a  href="{{route('sales_report.create')}}" class="btn btn-success">Generate sales report</a>

        <a  href="{{route('stock.show','edit_stock')}}" class="btn btn-success">Edit Stock</a>

                                           
        <br><br>

    <div class="row text-center">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Today's Total Sales</p>
                    <h2 class="text-success"><span data-plugin="counterup">UGX: {{number_format($sum_sales)}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->  


        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Today's Cash sales</p>
                    <h2 class="text-success"><span data-plugin="counterup">{{number_format($total_sales_today)}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Credit sales</p>
                    <h2 class="text-success"><span data-plugin="counterup">UGX:  {{number_format($debit_sales)}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col --> 
    </div>


    <div class="row text-center">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Credit purchases</p>
                    <h2 class="text-success"><span data-plugin="counterup">UGX: {{number_format($credit_purchase)}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col -->  

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Today's No. of sales</p>
                    <h2 class="text-success"><span data-plugin="counterup">{{number_format($sum_tickets)}}</span></h2>
                     
                </div>
            </div>
        </div><!-- end col --> 
    </div> 

 
            <div class="card-box">
                <div class="card-body">

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>Reciept Number</th>
                            <th>Date</th>
                            <th>Client name</th>
                            <th>Cost</th>
                            <th>Amount Paid</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php $sum = 0; $total_balance = 0;?>
                            @foreach($main_sales as $main_sale)
                              <tr>
                                  <td>{{$main_sale->id}}</td>
                                  <td>{{$main_sale->created_at}}</td>
                                  <td>{{$main_sale->client}}</td>
                                  <td>
                                      @php
                                      $sum_sales = 0; 
                                        foreach ($main_sale->sale as $sales_value) {
                                           $sum_sales = $sum_sales + ( ($sales_value->amount * $sales_value->size) - $sales_value->discount); 
                                        }
                                           echo number_format($sum_sales);
                                       @endphp
                                  </td>
                                  <td>

                                    @php 
                                     $payments_total = 0;
                                    @endphp
                                    @foreach($main_sale->salespayment as $details)
                                    @php
                                      $payments_total = $payments_total  + $details->amount;
                                    @endphp                                    
                                    @endforeach

                                    {{number_format($payments_total)}}

                                </td>

                                <td>{{number_format($sum_sales - $payments_total)}}</td>
                                 
                                <td><a href="{{route('main_sale.edit',$main_sale->id)}}" class="btn btn-success">Details</a></td>
                                    
                              </tr>

                               @php
                                 $sum = $sum + $sum_sales;
                                 $total_balance = $total_balance + ($sum_sales - $payments_total);
                               @endphp
                            @endforeach

                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th>{{number_format($sum)}}</th>
                                <th>{{number_format($sum - $total_balance)}}</th>
                                <th>{{number_format($total_balance)}}</th>
                                <th></th>
                               
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

@endsection
 
 