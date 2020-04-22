@extends('layouts.main')

@section('content')
    <h1>{{$title}}</h1>
 
    <div class="card-box">             
        <div class="card-body">                  
            <div class="row">
                <div class="col-md-12">
                    <label>Name</label>
                    <input type="text"  id="name" class="form-control">                         

                    <label>Phone number</label>
                    <input type="text" id="phone_number" class="form-control">

                    <label>Address</label>
                    <input type="text" id="address" class="form-control">                    
                    <span id="display"></span>

                    <br>
                    <button class="btn btn-success" id="saveBtn" type="submit">Save</button>
                    <br>
                </div>                      
            </div>
        </div>
    </div>     
@endsection
@push('scripts')
<script type="text/javascript">
    $("#expense_account_id").chosen();
    $("#saveBtn").click(function() {
        $("#saveBtn").text("Processing ...");
        $("#display").text("");
        $.ajax({
                type: "POST",
                url: "{{ route('customer.store') }}",
            data: {
                name: $("#name").val(),
                address: $("#address").val(),
                phone_number: $('#phone_number').val(),
                _token: "{{Session::token()}}"
            },
                success: function(result){                     
                    $("#display").text(result);
                    $("#saveBtn").text("Add new Customer");           
                }
        })
    });
</script>
@endpush
 