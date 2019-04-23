@extends('layouts.main')

@section('content')

  <h3 style="text-transform: uppercase;">{{$work_shifts->name}}, by {{$work_shifts->description}}, on {{date("d-m-Y",$work_shifts->date)}}</h3>
 
     
        <div class="card-box">
            <div class="card-body">
                

                <a href="" style="float: right;">Refresh</a>

                <ul class="nav nav-tabs m-b-10" id="myTab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="profile">Sales</a>
                  </li> 

                  

                  <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#bottles" role="tab" aria-controls="profile">Damaged items</a>
                  </li>
                </ul>
 
                <div class="tab-content">
                    <div id="sales" class="tab-pane fade in active">
                      <br>
                        <table class="table table-hover table-striped" id="sales_table">
                            <thead>
                                
                                <th>Date</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Buying price</th>
                                <th>Selling price</th>
                                <th>Discount</th>
                                <th>Amount</th>
                                <th>Gross Profit</th>
                            </thead>

                            <tbody>
                                <?php $sum = $sum_profit =  $sum_discount = 0; ?>
                                @foreach($sales as $sale)
                                <?php
                                  $main_sale = ($sale->amount * $sale->size)-$sale->discount;
                                  $profit = $main_sale - ($sale->buying_price * $sale->size);

                                  $sum_profit = $sum_profit + $profit;
                                  $sum = $sum + $main_sale;
                                  $sum_discount = $sum_discount + $sale->discount;
                                 ?>
                                  <tr>
                                      <td>{{$sale->created_at}}</td>
                                      <td>{{$sale->stock->category->name}} ({{$sale->stock->name}})</td>
                                      <td>{{$sale->size}} {{$sale->stock->category->unit}}</td> 
                                      <td>{{number_format($sale->buying_price)}}</td>
                                      <td>{{number_format($sale->amount)}}</td>
                                      <td>{{number_format($sale->discount)}}</td>
                                      <td>{{number_format($main_sale)}}</td>
                                      <td>{{number_format($profit)}}</td>
                                  </tr>
 
                                @endforeach

                                <tr>                                   

                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{number_format($sum_discount)}}</th>
                                <th>{{number_format($sum)}}</th>
                                <th>{{number_format($sum_profit)}}</th>
                                </tr>
                            </tbody>
                        </table>
                             
                        </div>

                 

                        <div id="bottles" class="tab-pane fade in">
                          <br>
                            <table class="table table-hover table-striped" id="loss">
                              <thead>
                                <th>Date created</th>  <th>Name</th> <th>Size</th> <th>Details</th> <th>Recorded by</th>
                              </thead>

                              <tbody>
                                @foreach($stock_loss as $losses)
                                  <tr>
                                    <td>{{$losses->created_at}}</td>  <td>{{$losses->name}}</td> <td>{{$losses->size}}</td> <td>{{$losses->description}}</td> <td>{{$losses->user->name}}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
     
@endsection

 