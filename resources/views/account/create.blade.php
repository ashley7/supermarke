@extends('layouts.main')

@section('content')
    <h4>Add Expense account</h4> 
    <div class="card-box">              
        <div class="card-body">
            <a href="{{route('account.index')}}" style="float: right;" class="btn btn-success">View account</a>
            <br><br>
            
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{route('account.store')}}">
                @csrf
                <label>Name</label>
                <input type="text" name="name" class="form-control">

                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
                <br>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>                  
        </div>
    </div>
         
@endsection