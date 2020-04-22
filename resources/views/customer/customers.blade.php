@extends('layouts.main')

@section('content')
    <h1>{{$title}}</h1>
    <a class="btn btn-success" href="{{route('customer.create')}}">Add customer</a>
    <br><br>
    <div class="card-box">    
       <div class="card-body">                           
          <table class="table table-hover table-striped" id="example">
            <thead>               
              <th>Name</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>Sales</th>              
            </thead>
            <tbody>
              @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->phone_number}}</td>
                    <td>{{$customer->address}}</td> 
                    <td><a href="{{route('customer.show',$customer->id)}}">Transaction</a></td>                        
                </tr>
              @endforeach             
            </tbody>
          </table>          
       </div>
     </div>
@endsection 