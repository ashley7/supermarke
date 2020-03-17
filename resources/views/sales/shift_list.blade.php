@extends('layouts.main')

@section('content')
 <h1>All shifts</h1>
 
  <div class="card-box">               
      <div class="card-body">
         <a class="btn btn-success" style="float: right;" href="{{route('work_shifts.create')}}">Add new shift</a>
          <br><br>
          
          <table class="table table-hover table-striped" id="example">
              <thead>
                  <th>#</th>
                  <th>Date created</th>
                  <th>Name</th>
                  <th>Workers</th>
                  <th>Created by</th>
                  <th>Action</th>                            
              </thead>

              <tbody>                         
                  @foreach($work_shift as $shifts)
                    <tr>
                        <td>{{$shifts->id}}</td>
                        <td>{{$shifts->created_at}}</td>
                        <td>{{$shifts->name}}</td>
                        <td>{{$shifts->description}}</td>                                  
                        <td>{{$shifts->user->name}}</td> 
                        <td>
                          <a class="btn btn-success" href="{{route('work_shifts.show',$shifts->id)}}">Details</a>
                        </td>                                
                    </tr>
                  @endforeach                
              </tbody>
          </table>
        </div>
  </div>
  @endsection
 