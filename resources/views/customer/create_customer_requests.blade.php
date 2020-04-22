@extends('layouts.main')

@section('content')
    <h1>{{$title}}</h1>
 
    <div class="card-box">             
        <div class="card-body">  
          <form method="POST" action="{{route('customer_request.store')}}">
          @csrf             
            <div class="row">
                <div class="col-md-12">
                    <label>Customer Name</label>
                    <select  name="customer_id" id="customer_id" class="form-control">
                        @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}} ( {{$customer->phone_number}} )</option>
                        @endforeach
                    </select>
                          

                    <label>Details</label>
                    <textarea class="form-control" name="details"></textarea>            

                    <br>
                    <button class="btn btn-success" type="submit">Save</button>
                    <br>
                </div>                      
            </div>
          </form>  
        </div>
    </div>     
@endsection
@push('scripts')
  <script type="text/javascript">
      $("#customer_id").chosen()
  </script>
@endpush
 
 