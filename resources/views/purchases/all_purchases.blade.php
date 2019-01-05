@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
     <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"> 

           <a href="{{route('purchases.create')}}" class="btn btn-primary">+ Purchase</a>
            <a href="{{route('supplier.create')}}" class="btn btn-primary">Supplier</a>
            <a href="{{route('purchases.index')}}" class="btn btn-primary">View Purchases</a>
            <a href="/purchases_report" class="btn btn-primary">Purchase report</a>   

            <br><br>  
       
        
            <div class="card">
                <div class="card-body">

                	<h2>All Purchases</h2>

                	<table class="table table-hover table-striped" id="example">
                		<thead>
                			<th>Date</th> <th>Supplier</th> <th>Amount</th> <th>Amount paid</th> <th>Balance</th> <th>Action</th>
                		</thead>

                		<tbody>
                			
                			@foreach($purchase as $purchases)
                            <?php $total = 0; ?>
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
                			@endforeach

                 		</tbody>
                	</table>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
     <script>
       $(document).ready(function() {
              $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    {
                        extend: 'excel',
                        messageTop: ''
                    },
                    {
                        extend: 'pdf',
                        messageTop: ''
                    },
                    {
                        extend: 'csv',
                        messageTop: null
                    }
                ]
            } );
        } );
    </script>

@endpush