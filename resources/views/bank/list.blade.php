@extends('layouts.main')

@section('content')
 <h1>List of Banks</h1>
  <div class="card-box">    
              

  <div class="card-body">
    <a class="btn btn-success" style="float: right;" href="{{route('bank.create')}}">Add bank</a>
    
      @if (session('status'))
          <div class="alert alert-success">
              {{ session('status') }}
          </div>
      @endif
  <div class="card-body">
     <h1></h1>
     <table class="table table-hover table-striped" id="expenses_table">
          <thead>
              <th>Name</th> <th></th>
          </thead>

          <tbody>

            @foreach($bank as $banks)
              <tr>
                <td>{{$banks->name}}</td>
                <td><a class="btn btn-success" href="{{route('bank.show',$banks->id)}}">Show Deposits</a></td>
              </tr>
            @endforeach
                                  
          </tbody>                      
      </table>
    </div>
  </div>
</div>              
@endsection 