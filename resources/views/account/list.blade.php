@extends('layouts.main')

@section('content')
<h1>{{$expense_title}}</h1>
 
            <div class="card-box">
               <div class="card-body">                   
                  <a class="btn btn-primary right" style="float: right;" href="{{route('account.create')}}">Add account</a>
                  
                  @if (session('status'))
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
                  @endif

                  <?php $total=0; ?>
                  <table class="table table-hover table-striped" id="example">
                      <thead>
                         <th>#</th> <th>Name</th> <th>Description</th> <th>Total amounts</th> <th>Action</th>
                      </thead>

                      <tbody>
                          @foreach($accounts as $account)
                          <?php 
                           $accounts=App\Expense::all()->where('expense_account_id',$account->id)->sum('amount');
                           $total=$total+ $accounts

                           ?>
                            <tr>
                                <td>{{$account->id}}</td>
                                <td>{{$account->name}}</td>
                                <td>{{$account->description}}</td>
                                <td>{{number_format($accounts)}}</td>
                                <td>
                                  <a class="btn btn-success" href="{{route('account.show',$account->id)}}">Show</a>
                                  <a class="btn btn-primary" href="{{route('account.edit',$account->id)}}">Edit</a>
                                </td>
                            </tr>
                          @endforeach 
                          <td>Total</td> <td></td> <td></td> <td>{{number_format($total)}}</td> <td></td>                           
                      </tbody>                      
                  </table>               
              </div>
              </div>

        
@endsection
 