@extends('layouts.main')

@section('content')
          <h1>Add category</h1>
 
            <div class="card-main">
                <div class="card-body">
          
                    <a href="{{route('stock.create')}}">Add stock</a>
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" id="name" autofocus="true" class="form-control">

                            <label>Selling Unit of measure</label>                          
                            <input type="text" id="unit" class="form-control">
                            <br><br>
                            <button class="btn btn-primary" id="saveBtn">Save</button>
                        </div>
                        <h3 id="display" style="color: green;"></h3>
                        <input type="hidden" class="number">
                 </div>
             </div>
             
       
@endsection

@push('scripts')
  <script>
       $("#saveBtn").click(function() {
        $.ajax({
                type: "POST",
                url: "{{ route('category.store') }}",
            data: {
                name: $("#name").val(),                              
                unit: $("unit").val(),                              
                _token: "{{Session::token()}}"
            },
                success: function(result){
                    $('#name').val(" ")
                    $('#unit').val(" ")
                  }
        })
    });
  </script>
@endpush