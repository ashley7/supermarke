@extends('layouts.main')

@section('content')
    <h1>{{$title}}</h1>
 
    <div class="card-box">
       <div class="card-body">
         <a href="{{route('sales.create')}}" style="float: right;" class="btn btn-primary">Create Sales</a>
            <br><br>

                <table class="table table-hover table-striped" id="example">
                    <thead>                                
                        <th>Sale ID</th>                               
                        <th>Date</th>
                        <th>Item Name</th>
                        <th>Customer</th>
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
                              <td>{{$sale->mainsales_id}}</td>
                              <td>{{$sale->created_at}}</td>
                              <td>{{$sale->stock->category->name}} ({{$sale->stock->name}})</td>
                              <td>
                                {{$sale->mainsale->customer->name}}<br>
                                {{$sale->mainsale->customer->phone_number}}                                 
                              </td>
                              <td>{{$sale->size}}</td>
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
                        <th></th>
                        <th></th>
                        <th>{{number_format($sum_discount)}}</th>
                        <th>{{number_format($sum)}}</th>
                        <th>{{number_format($sum_profit)}}</th>
                         
                        </tr>
                  </tbody>
              </table>
            </div>
          </div>

  
@endsection

 