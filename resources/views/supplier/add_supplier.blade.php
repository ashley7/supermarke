@extends('layouts.main')

@section('content')
   <h1>Add Supplier</h1>
 
            <div class="card-box">
                <div class="card-body">
                  
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

@endpush