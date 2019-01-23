@extends('layouts.main')

@section('content')
     <h1>Edit price for {{$read_tags->stock->category->name}} ({{$read_tags->stock->name}})</h1>
 
            <div class="card-box">
                <div class="card-body">
               
 
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{route('price_tag.update',$read_tags->id)}}">
                        @csrf
                        {{method_field('PATCH')}}
                   
                        <div class="col-md-6">                             
                            <label>Buying Price</label>
                            <input type="text" name="buying_price" value="{{$read_tags->buying_price}}" class="form-control next_number">

                            <label>salling Price</label>
                            <input type="text" name="salling_price" value="{{$read_tags->salling_price}}" class="form-control number">
                            <br>
                            <button class="btn btn-primary" id="saveBtn">Update</button>

                        </div>
                    </form>
                </div>
            </div>
        
                       
@endsection


@push('scripts')
  <script>
       $("#saveBtn").click(function() {
        $.ajax({
                type: "PATCH",
                url: "{{ route('price_tag.update',$read_tags->id) }}",
            data: {
                name: $("#name").val(),                           
                barcode: $("#barcode").val(),                           
                price: $("#price").val(),                           
                _token: "{{Session::token()}}"
            },
              success: function(result){
                alert(result);
             }
        });
    });
  </script>
@endpush

 