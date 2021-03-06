@extends('layouts.main')

@section('content')
<h1>Edit Bank Deposit</h1>
 
            <div class="card-box">               

                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                  {{Form::model($read_bankdeposit,['files' => true,'method'=>'PATCH', 'action'=>['BankDepositController@update', $read_bankdeposit->id]])}} 

                  <div class="row">
                        <div class="col-md-6">

                        <label>Transaction type</label>
                        <select name="transaction_type" class="form-control">
                            <option></option>
                            <option value="Deposit">Deposit</option>
                            <option value="Withdraw">Withdraw</option>
                        </select>       
                        <label>Amount</label>
                        <input type="text" name="amount" value="{{$read_bankdeposit->amount}}" step="any" class="form-control number">

                        <label>Number</label>
                        <input type="text" name="voucher_number" value="{{$read_bankdeposit->voucher_number}}" class="form-control">

                        <label>Choose Bank</label>
                        <select class="form-control" name="bank_id">
                            <option></option>
                            @foreach(App\Bank::all() as $banks)
                              <option value="{{$banks->id}}">{{$banks->name}}</option>
                            @endforeach
                        </select>

                        <label>Deposited by</label>
                        <select class="form-control" name="deposited_by">
                            <option></option>
                            @foreach(App\User::all() as $users)
                              <option value="{{$users->id}}">{{$users->name}}</option>
                            @endforeach
                        </select>

                        <label>Date of Deposit</label>
                        <input type="date" value="{{$read_bankdeposit->date}}" name="date" class="form-control">
                        <br>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
               {{Form::close()}}                  
            </div>
        </div>

           
@endsection