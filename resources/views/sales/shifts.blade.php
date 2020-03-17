@extends('layouts.main')

@section('content')
  <h1>Create a new work shift</h1>

  
  <br>
 
    <div class="card-box">
        <div class="card-body">
           

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <a href="{{route('work_shifts.index')}}" style="float: right;" class="btn btn-success">View shifts</a>
            <br><br>

            
                <div class="col-md-6 col-lg-6">
                    <form method="POST" action="{{route('work_shifts.store')}}">

                        @csrf
                      
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"> 

                        <label>Workers on shift</label>
                        <input type="text" name="description" class="form-control">

                        <br>
                        
                        <button class="btn btn-success" type="submit">Save</button>
                    </form>
                </div>                       
        </div>
    </div>        
@endsection