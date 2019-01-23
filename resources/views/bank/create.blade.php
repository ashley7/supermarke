@extends('layouts.main')

@section('content')
<h1>Add Bank</h1>
    <div class="card-box">           
        <div class="card-body">
             <a href="{{route('bank.index')}}" style="float: right;" class="btn btn-primary">View Banks</a>
             <br><br>
            
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{route('bank.store')}}">
                @csrf           
                <label>Bank Name</label>
                <input type="text" name="name" class="form-control">
                <br>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>                  
        </div>
    </div>        
@endsection