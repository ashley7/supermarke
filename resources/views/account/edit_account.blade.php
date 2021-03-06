@extends('layouts.main')

@section('content')
    <h4>Add Expense account</h4> 
    <div class="card-box">              
        <div class="card-body">
            
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {{Form::model($expense_account,['files' => true,'method'=>'PATCH', 'action'=>['ExpenseaccountController@update', $expense_account->id]])}}  
                @csrf
                <label>Name</label>
                <input type="text" name="name" value="{{$expense_account->name}}" class="form-control">

                <label>Description</label>
                <input type="text" value="{{$expense_account->description}}" name="description" class="form-control">
               
                <br>
                <button class="btn btn-success" type="submit">Save</button>
            {{Form::close() }}                  
        </div>
    </div>
     
@endsection