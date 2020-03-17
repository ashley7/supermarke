@extends('layouts.main')

@section('content')
   <h1>{{$title}}</h1>

      <a class="btn btn-success" href="{{route('expense.create')}}">Add Expense</a>
      <a class="btn btn-primary" href="{{route('reports.create')}}">Generate Report</a>

      <br><br>
 
            <div class="card-box">    
               <div class="card-body">
                  @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php $total=0; ?>
                    <table class="table table-hover table-striped" id="example">
                      <thead>
                        <th>#</th>
                        <th>Transaction date</th>
                        <th>Voucher number</th>
                        <th>Particular</th>
                        <th>Expense account</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Actions</th>
                      </thead>

                      <tbody>
                        @foreach($expense as $account)
                          <tr>
                              <td>{{$account->id}}</td>
                              <td>{{date('d M Y',$account->date)}}</td>
                              <td>{{$account->voucher_number}}</td>
                              <td>{{$account->particular}}</td>
                              <td>{{$account->expenseaccount->name}}</td>
                              <td>{{$account->person_name}}</td>
                              <td>{{$account->phone_number}}</td>
                              <td>{{$account->size}}</td>
                              <td>{{number_format($account->amount)}}</td>
                              <?php $total=$total+$account->amount; ?>
                              <td>
                                 <form action="/expense/{{ $account->id }}" method="POST">
                                    {{method_field('DELETE')}}
                                    {{ csrf_field() }}
                                    <a href="{{route('expense.edit',$account->id)}}" class="btn btn-info">Edit</a>
                                    <!-- <input type="submit" class="btn btn-danger" value="Delete"/> -->
                                </form>
                              </td>
                          </tr>
                        @endforeach
                        <tr>
                            <th>Total</th> <th></th> <th></th> <th></th> <th></th> <th></th><th></th> <th></th><th><?php echo number_format($total) ?></th><th></th>
                        </tr>
                      </tbody>
                    </table>          
                 </div>
               </div>

               <br>
               <h5>Expense accounts</h5>
               <br>

            <div class="card-box">    
               <div class="card-body">





                  @if(empty($from))

                    <?php  $total=0; ?>


                    <div class="card-body">
                       <h1></h1>
                       <table class="table table-hover table-striped" id="expenses_table">
                            <thead>
                              <th>#</th>  <th>Name</th> <th>Description</th> <th>Total amounts</th> <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach($accounts as $account)
                                <?php 
                                 $accounts=App\Expense::all()->where('expense_account_id',$account->id)->sum('amount');
                                 $total=$total+ $accounts;                           

                                 ?>
                                  <tr>
                                      <td>{{$account->id}}</td>
                                      <td>{{$account->name}}</td>
                                      <td>{{$account->description}}</td>
                                      <td>{{number_format($accounts)}}</td>
                                      <td><a class="btn btn-success" href="{{route('account.show',$account->id)}}">Show</a>
                                      <a class="btn btn-primary" href="{{route('account.edit',$account->id)}}">Edit</a>

                                      </td>
                                  </tr>
                                @endforeach 
                                <td>Total</td><td></td> <td></td> <td>{{number_format($total)}}</td> <td></td>                           
                            </tbody>                      
                        </table>
                      </div>
                  @else

                  <?php  $total=0 ?>

                    <div class="card-body">
                       <h1></h1>
                       <table class="table table-hover table-striped" id="expenses_table">
                            <thead>
                              <th>#</th>  <th>Name</th> <th>Description</th> <th>Total amounts</th> <th>Action</th>
                            </thead>

                            <tbody>
                                @foreach($accounts as $account)
                                <?php 
                                 $accounts=App\Expense::whereBetween('date', [$from,$to])->where('expense_account_id',$account->id)->sum('amount');
                                 $total=$total+ $accounts;

                                 $id=$account->id."_".$from."_".$to;                         

                                 ?>
                                  <tr>
                                      <td>{{$account->id}}</td>
                                      <td>{{$account->name}}</td>
                                      <td>{{$account->description}}</td>
                                      <td>{{number_format($accounts)}}</td>
                                      <td><a class="btn btn-primary" href="{{route('reports.show',$id)}}">Show expenses</a></td>
                                  </tr>
                                @endforeach 
                                <td>Total</td> <td></td> <td></td> <td>{{number_format($total)}}</td> <td></td>                           
                            </tbody>                      
                        </table>
                      </div>

                  @endif
                </div>
              </div>
@endsection

 