@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">        
        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
        
            <div class="card">
                <div class="card-body">

                	<h2>{{$title}}</h2>

                	<table class="table table-hover table-striped" id="example">
                		<thead>
                			<th>Date</th> <th>Supplier</th> <th>Item</th> <th>Amount</th>
                		</thead>

                		<tbody>
                			<?php $total = 0; ?>
                			@foreach($purchase as $purchases)
                			  <tr>
                			  	<td>{{$purchases->created_at}}</td>
                			  	<td>{{$purchases->parchase->supplier->name ?? ''}} </td>
                			  	<td>{{$purchases->quantity}} {{$purchases->stock->category->name}} ({{$purchases->stock->name}}) @ {{number_format($purchases->unit_price)}}</td>
                			  	<td>{{number_format($purchases->quantity * $purchases->unit_price)}}</td>
                			  </tr>

                			  <?php 
                			    $total = $total + ($purchases->quantity * $purchases->unit_price);

                			   ?>
                			@endforeach

                			<th>Total</th> <th> </th> <th> </th> <th>{{number_format($total)}}</th>
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