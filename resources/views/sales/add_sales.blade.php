@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
                          
        <a  href="{{route('main_sale.create')}}"  class="btn btn-danger">+ New Sale</a> 
        <a  href="{{route('work_shifts.create')}}"  class="btn btn-primary">+ New shift</a>
        <a  href="{{route('price_tag.create')}}" class="btn btn-secondary">+ Price tags</a> 
        <a  href="{{route('sales.index')}}"  class="btn btn-warning" style="color: #FFF">View Sales</a>
        <a  href="{{route('stock_loss.create')}}"  class="btn btn-danger" style="color: #FFF">Record Stock loss</a>        
        <a  href="{{route('sales_barcodes.create')}}" class="btn btn-success">Generate barcodes</a>
        <a  href="{{route('sales_report.create')}}" class="btn btn-info">Generate report</a>
                                           
        <br><br>
            

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Today's Total Sales</span><br>
                            <span style="font-size: 50px">UGX: {{number_format($sum_sales)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                         <div class="card-body">
                            <span style="font-size: 20px; color: red;">Number of Reciepts</span><br>
                            <span style="font-size: 50px">{{number_format($sum_tickets)}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <br>


            <div class="card">
                <div class="card-body">

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>#</th>
                            <th>Date</th>
                            <th>Reciept Number</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php $sum = 0; ?>
                            @foreach($main_sales as $main_sale)
                              <tr>
                                  <td>{{$main_sale->id}}</td>
                                  <td>{{$main_sale->created_at}}</td>
                                  <td>{{$main_sale->sales_number}}</td>
                                  <td>{{number_format($main_sale->sale->sum('amount'))}}</td>
                                  <td><a href="{{route('main_sale.edit',$main_sale->id)}}" class="btn btn-success">Details</a></td>
                              </tr>

                              <?php
                                 $sum = $sum + $main_sale->sale->sum('amount');
                               ?>
                            @endforeach

                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                               
                                <th>{{number_format($sum)}}</th>
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

 