@extends('layouts.main')

@section('content')
            <h1>Users</h1>
 
            <div class="card-box">    
             

                <div class="card-body">
                  <a class="btn btn-primary" href="{{route('user.create')}}" style="float: right;">Add User</a>
                  <br><br>
                   @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

              

                <div class="card-body">
                   <h1></h1>
                   <table class="table table-hover table-striped" id="expenses_table">
                        <thead>
                            <th>#</th> <th>Name</th> <th>Phone</th>
                        </thead>

                        <tbody>

                          @foreach($user as $users)
                            <tr>
                              <td>{{$users->id}}</td>
                              <td>{{$users->name}}</td>
                              <td>{{$users->phone_number}}</td>
                              
                             </tr>
                          @endforeach
                                                
                        </tbody>                      
                    </table>
                  </div>
                </div>
              </div>

             

@endsection
 