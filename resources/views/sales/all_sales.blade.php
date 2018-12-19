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
                            <th>#</th>
                            <th>Date</th>
                            <th>Ticket Number</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <?php $sum = 0; ?>
                            @foreach($main_sales as $main_sale)
                                <?php
                                  if ($main_sale->sale->sum('amount') == 0) {
                                      App\MainSale::destroy($main_sale->id);
                                  }else{
                                     $sum = $sum + $main_sale->sale->sum('amount');
                                  }
                                ?>
                              <tr>
                                  <td>{{$main_sale->id}}</td>
                                  <td>{{$main_sale->created_at}}</td>
                                  <td>{{$main_sale->sales_number}}</td>
                                  <td>{{number_format($main_sale->sale->sum('amount'))}}</td>
                                  <td><a href="{{route('main_sale.edit',$main_sale->id)}}" class="btn btn-success">Details</a></td>
                              </tr>                      
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