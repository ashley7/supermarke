@extends('layouts.main')

@section('content')
  <h1>{{$title}}</h1>
  <div class="card-main">
    <div class="card-body">
        <form method="POST" action="{{route('adhoc_report.store')}}">
         @csrf
         <div class="row">
            <div class="col-md-6">
                <label>From</label>
                <input type="date" name="from" class="form-control">           
            </div>

            <div class="col-md-6">
              <label>To</label>
              <input type="date" name="to" class="form-control">             
            </div>
         </div>
         <hr>
         <button type="submit" class="btn btn-info">Generate</button>
        </form>
    </div>
  </div>       
@endsection
 