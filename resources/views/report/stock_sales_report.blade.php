@extends('layouts.main')

@section('content')
  <h1>{{$title}}</h1>
  <div class="card-main">
    <div class="card-body">
        <form method="POST" action="{{route('stock_sales.store')}}">
         @csrf
         <div class="row">
            <div class="col-md-6">
                <label>From</label>
                <input type="date" max="{{date('Y-m-d')}}" name="from" class="form-control">           
            </div>

            <div class="col-md-6">
              <label>To</label>
              <input type="date" max="{{date('Y-m-d')}}" name="to" class="form-control">             
            </div>

            <div class="col-md-6">
                <label>Select products of intrest</label>
                <select class="form-control" multiple name="stock_id[]" id="stock_id">
                  @foreach($stocks as $stock)

                    <option value="{{$stock->id}}">{{$stock->category->name}} ({{$stock->name}})</option>

                  @endforeach
                </select>          
            </div>
         </div>
         <hr>
         <button type="submit" class="btn btn-info">Generate</button>
        </form>
    </div>
  </div>       
@endsection

@push('scripts')
  <script>
    $("#stock_id").chosen({
      width:"100%"
    });
  </script>
@endpush