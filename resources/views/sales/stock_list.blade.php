@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    <h1>All Stock Item Names</h1>

                    <a href="{{route('stock.create')}}" style="float: right;" class="btn btn-primary">Create Stock</a>
                    <br><br>

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Re-order level</th>
                            <th>No. of sales</th>                       
                            <th>Action</th>                           
                        </thead>

                        <tbody>                         
                            @foreach($stock as $stock_details)
                              <tr>
                                 <td style="text-transform: uppercase;">{{$stock_details->category->name}}</td>
                                 <td style="text-transform: uppercase;">{{$stock_details->name}}</td>
                                 <td>{{$stock_details->keeping_limit}}</td>
                                 <td>{{$stock_details->sales->count()}}</td>
                                 <td><a href="{{route('stock.edit',$stock_details->id)}}">Edit</a></td>
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