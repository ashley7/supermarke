@extends('layouts.main')

@section('content')
 <h2>{{$title}}</h2>
        
            <div class="card-box">
                <div class="card-body">

                	

                	<table class="table table-hover table-striped" id="example">
                		<thead>
                			<th>Date</th> <th>Supplier</th> <th>Item</th> <th>Quantity</th> <th>Buying price</th> <th>Amount</th>
                		</thead>

                		<tbody>
                			<?php $total = 0; ?>
                			@foreach($purchase as $purchases)
                			  <tr>
                			  	<td>{{$purchases->created_at}}</td>
                			  	<td>{{$purchases->parchase->supplier->name ?? ''}} </td>
                                <td>{{$purchases->stock->category->name}} ({{$purchases->stock->name}})</td>
                			  	<td>{{$purchases->quantity}} {{$purchases->stock->category->unit}}</td>
                                <td> {{number_format($purchases->unit_price)}}</td>
                			  	<td>{{number_format($purchases->quantity * $purchases->unit_price)}}</td>
                			  </tr>

                			  <?php 
                			    $total = $total + ($purchases->quantity * $purchases->unit_price);

                			   ?>
                			@endforeach

                			<th>Total</th> <th> </th> <th> </th> <th> </th> <th> </th> <th>{{number_format($total)}}</th>
                		</tbody>
                	</table>
                </div>
            </div>
   
@endsection
 