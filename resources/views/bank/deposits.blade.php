@extends('layouts.main')

@section('content')
<h1>{{$title}}</h1>
 
            <div class="card-box">  
                <div class="card-body">
                  <a class="btn btn-success" href="{{route('bank_deposite.create')}}">Add Bank Transaction</a>
                  <a class="btn btn-success" href="{{route('bank.index')}}">Bank</a>
                  <a class="btn btn-success" href="{{route('bank.create')}}">Add Bank</a>
                  <a href="/bankreport" class="btn btn-success">Generate Report</a>                
                              
                  
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php $total_deposit = $total_withdraw = 0; ?>
                 <div class="card-body">
                   <h1></h1>
                   <table class="table table-hover table-striped" id="expenses_table">
                        <thead>
                          <th>#</th> 
                          <th>Date</th>
                          <th>by</th>
                          <th>Bank</th>
                          <th>Reciept Number</th>
                          <th>Type</th>
                          <th>Deposit</th>
                          <th>Withdraw</th>
                          <th>Recorded by</th>
                          <th>Action</th>
                        </thead>

                        <tbody>
                          @foreach($deposits as $deposit)
                            <tr>
                              <td>{{$deposit->id}}</td>
                              <td>{{date('d-m-Y',$deposit->date)}}</td>
                              <td>{{App\User::find($deposit->deposited_by)->name}}</td>
                              <td>{{$deposit->bank->name}}</td>
                              <td>{{$deposit->voucher_number}}</td>
                              <td>{{$deposit->transaction_type}}</td>
                              <td>
                                @if($deposit->transaction_type == "Deposit")
                                  {{number_format($deposit->amount)}}
                                  <?php $total_deposit = $total_deposit +  $deposit->amount;?>
                                @endif
                              </td>
                              <td>
                                @if($deposit->transaction_type == "Withdraw")
                                  {{number_format($deposit->amount)}}
                                  <?php $total_withdraw = $total_withdraw +  $deposit->amount;?>
                                @endif
                              </td>
                               <td>{{$deposit->user->name}}</td>
                               <td>

                                 <form action="/bank_deposite/{{ $deposit->id }}" method="POST" onsubmit = 'return confirm("Are you sure you want to proceed?"); return false;'>
                                    {{method_field('DELETE')}}

                                    {{ csrf_field() }}
                                    <a href="{{route('bank_deposite.edit',$deposit->id)}}" class="btn btn-info">Edit</a>
                                    <input type="submit" class="btn btn-danger" value="Delete"/>
                                </form>
                               </td>
                            </tr>
                            
                          @endforeach
                          <tr>
                             <th>Total</th> <th></th> <th></th><th></th><th></th> <th></th> <th>{{number_format($total_deposit)}}</th> <th>{{number_format($total_withdraw)}}</th> <th></th> <th></th>
                          </tr>                                                
                        </tbody>                      
                    </table>
                  </div>

                   <div class="card-body">
                   <h1></h1>
                   <table class="table table-hover table-striped" id="example">
                        <thead>
                          <th>#</th>  <th>Bank name</th>  <th>Total Deposit</th> <th>Total withdraw</th>
                            @if(!empty($from))
                              <th></th>
                            @endif
                        </thead>               


                        <tbody>
                          @foreach($banks as $bank)
                            <tr>
                              <td>{{$bank->id}}</td>
                              <td>{{$bank->name}}</td>
                              @if(empty($from))
                                  <td>{{number_format(  App\BankDeposit::all()->where('bank_id',$bank->id)->where('transaction_type','Deposit')->sum('amount'))}}
                                  </td>

                                  <td>{{number_format(  App\BankDeposit::all()->where('bank_id',$bank->id)->where('transaction_type','Withdraw')->sum('amount'))}}
                                  </td>
                                @else
                                  <td>{{number_format(App\BankDeposit::where('bank_id',$bank->id)->where('transaction_type','Deposit')->whereBetween('date', [$from,$to])->sum('amount'))}}</td>

                                  <td>{{number_format(App\BankDeposit::where('bank_id',$bank->id)->where('transaction_type','Withdraw')->whereBetween('date', [$from,$to])->sum('amount'))}}</td>

                                  <?php $id=$bank->id."_".$from."_".$to?>

                                  <td><a href="{{route('bank.edit',$id)}}">Show Details</a></td>
                                @endif

                            </tr>
                            
                          @endforeach
                                                                       
                        </tbody>                      
                    </table>
                  </div>




                </div>
              </div>
            </div>
          </div>
        </div>         

@endsection
 