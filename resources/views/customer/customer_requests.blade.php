@extends('layouts.main')

@section('content')
    <h1>{{$title}}</h1>
    <a class="btn btn-success" href="{{route('customer_request.create')}}">Add customer request</a>
    <br><br>
    <div class="card-box">    
       <div class="card-body">                           
          <table class="table table-hover table-striped" id="example">
            <thead>               
              <th>Name</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>Particulars</th>
              <th>Status</th>            
            </thead>
            <tbody>
              @foreach($customer_request as $reques)
                <tr>
                    <td>{{$reques->customer->name}}</td>
                    <td>{{$reques->customer->phone_number}}</td>
                    <td>{{$reques->customer->address}}</td> 
                    <td>{{$reques->details}}</td>                        
                    <td>
                      @if($reques->status == "Not resolved")
                          <a href="{{route('customer_request.edit',$reques->id)}}" class="text-danger" title="Change status">{{$reques->status}}</a>
                        @elseif($reques->status == "Resolved")
                          <a href="{{route('customer_request.edit',$reques->id)}}" class="text-success" title="Change status">{{$reques->status}}</a>
                      @endif
                   </td> 
                </tr>
              @endforeach             
            </tbody>
          </table>          
       </div>
     </div>
@endsection 