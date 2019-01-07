@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
                          
        <a  href="{{route('main_sale.create')}}"  class="btn btn-success">+ New Sale</a> 
        <!-- <a  href="{{route('work_shifts.create')}}"  class="btn btn-primary">+ New shift</a> -->
        <!-- <a  href="{{route('price_tag.create')}}" class="btn btn-secondary">+ Price tags</a>  -->
        <a  href="{{route('sales.index')}}"  class="btn btn-warning" style="color: #FFF">View Sales</a>
        <a  href="{{route('stock_loss.create')}}"  class="btn btn-danger" style="color: #FFF">Record Stock loss</a>        
        <a  href="{{route('sales_report.create')}}" class="btn btn-info">Generate sales report</a>
                                           
        <br><br>          
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Today's Total Sales</span><br>
                            <span style="font-size: 30px">UGX: {{number_format($sum_sales)}}</span>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Today's Cash sales</span><br>
                            <span style="font-size: 30px">{{number_format($total_sales_today)}}</span>
                        </div>
                    </div>
                </div>                
            </div>
            <br>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Total Debit sales</span><br>
                            <span style="font-size: 30px">{{number_format($debit_sales)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Total Credit purchase</span><br>
                            <span style="font-size: 30px">{{number_format($credit_purchase)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Today's No. of sales</span><br>
                            <span style="font-size: 30px">{{number_format($sum_tickets)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>Reciept Number</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Cost Paid</th>
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

 