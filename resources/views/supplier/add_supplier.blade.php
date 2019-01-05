@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Add Supplier</h1>
                        <div class="col-md-6">
                            <label>Name *</label>
                            <input type="text" id="name"  class="form-control">

                            <label>Phone number *</label>
                            <input type="text" id="phone_number"  class="form-control">   

                            <label>Address</label>
                            <input type="text" id="address"  class="form-control">   
                            <br>
                            <button class="btn btn-primary" id="saveBtn">Save</button>
                            <a href="" style="float: right;">Refresh</a>
                        </div>
                        <h3 id="display" style="color: green;"></h3>
                        <input type="hidden" class="number">
                        <h1>Supplier List</h1>

                        <table class="table" id="example">
                            <thead>
                                <th>Name</th>
                                <th>Phone number</th>
                                <th>Address</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach($suppliers as $supplier)
                                  <tr>
                                      <td style="text-transform: uppercase;">{{$supplier->name}}</td>
                                      <td>{{$supplier->phone_number}}</td>
                                      <td>{{$supplier->address}}</td>
                                      <td>
                                          <a href="{{route('supplier.edit',$supplier->id)}}">Edit</a>
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
  <script>
       $("#saveBtn").click(function() {
            $("#saveBtn").text("Processing ...");
            $("display").html("")
            $.ajax({
                    type: "POST",
                    url: "{{ route('supplier.store') }}",
                data: {
                    name: $("#name").val(),                              
                    phone_number: $("#phone_number").val(),                              
                    address: $("#address").val(),                              
                    _token: "{{Session::token()}}"
                },
                    success: function(result){
                        $("display").html(result)
                        $("#name").val(" ")
                        $("#phone_number").val(" ")
                        $("#address").val(" ")
                        $("#saveBtn").text("Add new Supplier");
                }
            })
    });
  </script>

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