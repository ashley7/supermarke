@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
               

                <div class="card-body">
                    <h5 style="text-transform: uppercase;">{{$title}}</h1>

                    <a href="{{route('sales.create')}}" style="float: right;" class="btn btn-primary">Create Sales</a>
                    <br><br>

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>Reciept Number</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Cost to Pay</th>
                            <th>Amount Paid</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php 
                               $sum = 0; $total_balance = 0;
                            ?>
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

                              <?php
                                 $sum = $sum + $sum_sales;
                                 $total_balance = $total_balance + ($sum_sales - $payments_total);
                               ?>
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
        </div>
    </div>
</div>
@endsection

@push('scripts')
     <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
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
                        messageTop: '{{$title}}'
                    },
                    {
                        extend: 'pdf',
                        messageTop: '{{$title}}'
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