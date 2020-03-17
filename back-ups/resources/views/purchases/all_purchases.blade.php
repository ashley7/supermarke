@extends('layouts.main')

@section('content')
<h2>All Purchases</h2>
 
   

            <a href="{{route('purchases.create')}}" class="btn btn-primary">+ Purchase</a>
            <a href="{{route('supplier.create')}}" class="btn btn-primary">Supplier</a>
            <a href="{{route('purchases.index')}}" class="btn btn-primary">View Purchases</a>
            <a href="/purchases_report" class="btn btn-primary">Purchase report</a>   

            <br><br>  
       
        
            <div class="card-box">
                <div class="card-body">

                	

                	<table class="table table-hover table-striped" id="example">
                		<thead>
                			<th>Date</th> <th>Supplier</th> <th>Amount</th> <th>Amount paid</th> <th>Balance</th> <th>Action</th>
                		</thead>

                		<tbody>
                            <?php
                               $total_amount = $total_amount_paid = 0;
                             ?>
                			
                			@foreach($purchase as $purchases)
                            <?php $total  = 0; ?>
                			  <tr>
                			  	<td>{{$purchases->created_at}}</td>
                			  	<td>{{$purchases->supplier->name ?? ''}} </td>
                                <td>
                                    @foreach($purchases->parchasedetails as $details)
                                    <?php
                                      $total = $total  + ($details->unit_price * $details->quantity);
                                    ?>
                                    @endforeach

                                    {{number_format($total)}}
                                </td>
                                <td>
                                    <?php 
                                     $payments_total = 0;
                                     ?>
                                    @foreach($purchases->parchasepayment as $details)
                                    <?php
                                      $payments_total = $payments_total  + ($details->amount);
                                    ?>
                                    @endforeach
                                    {{number_format($payments_total)}}
                                </td>
                                <td>
                                    {{number_format($total - $payments_total)}}
                                </td>
                                <td>
                                    <a href="{{route('purchases.edit',$purchases->id)}}" class="btn btn-primary">Details</a>
                                </td>
                			  </tr> 
                              <?php
                                $total_amount = $total_amount + $total;
                                $total_amount_paid = $total_amount_paid + $payments_total;
                               ?>            			 
                			@endforeach

                            <tr>
                                <th>Total</th> <th></th> <th>{{number_format($total_amount)}}</th> <th>{{number_format($total_amount_paid)}}</th> <th>{{number_format($total_amount - $total_amount_paid)}}</th> <th></th>
                            </tr>

                 		</tbody>
                	</table>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection
 