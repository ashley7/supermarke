@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
            <div class="row">
                		<div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 exclude">
                			<a href="#" onclick="myFunction()" ><i class="material-icons">print</i></a>
                		</div>
                		<div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 include">
                			<center>
	                			<p style="text-transform: uppercase;">{{ config('app.name') }}</p>
	                			<p>Dealers in Building Materials, Plumbing and Electrical materials</p>
	                			<p>Phone: +256 701 626 689 | +256 772 526 689</p>
                                <h3><u>RECIEPT</u></h3>
                			</center>
                			
                			<p style="float: left;">Date.{{date('d-M-Y',$update_sales_shift->period_recorded)}}</p>
                            <span style="float: right;">No.{{$update_sales_shift->sales_number}}</span>
                			<?php $total = $items = 0; ?>
                			<br>
                            <table class="table">
                				<thead>
                					<th>Item</th> <th>Amount</th>
                				</thead>
                				<tbody>
                					@foreach($update_sales_shift->sale as $sales)
                					<?php
                					 $unit_price = App\PriceTag::all()->where('barcode',$sales->number)->last();
                					 $total = $total + $sales->amount;
                					 $items = $items + $sales->size;
                					 ?>
                					  <tr>
                					  	<td>{{$sales->size}} {{$sales->name}}(s) (@ {{number_format($unit_price->price)}})</td> <td>{{number_format($sales->amount)}}</td>
                					  </tr>
                					@endforeach
                					<tr>
                						<th>Total</th> <th>{{number_format($total)}}</th>
                					</tr>
                				</tbody>
                			</table>
                            <p>Total items: {{$items}}</p>
                			<p>You were served by: {{$update_sales_shift->user->name}}</p>
                			<p>Thank you, Please come again next time ...</p>
                			<p style="float: left;"><i>Point of Sale Software: +256 787 444 081</i></p>
                		</div>
                		<div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 exclude">
                            <a href="#" onclick="myFunction()" ><i class="material-icons">print</i></a>      
                        </div>
                	</div>

            </div>
        </div>
  
@endsection

@section('style')
 <style type="text/css">
    @media print{
      .exclude,nav{
        display: none;      
	    }
	}
 	.include{
      border-style: solid;
      border-color: red;
      border-width: 5px 5px 5px 5px;
      border-radius: 7px;
   }
 </style>
@endsection
