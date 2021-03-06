@extends('layouts.main')

@section('content')
<h1>Add User</h1>

<div class="card-box">              
    <div class="card-body">  

       <div class="row">
           <div class="col-md-6">
             
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{route('user.store')}}">
                    @csrf                         

                    <label>Person name</label>
                    <input type="text" name="name" class="form-control">

                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-control">

                    <label>Email</label>
                    <input type="text" name="email" class="form-control">
                    <br>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>                  
            </div>
        </div>
    </div>
</div>
            
   
@endsection