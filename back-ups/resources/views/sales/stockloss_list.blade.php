@extends('layouts.main')

@section('content')
 
            <div class="card-box">              
                <div class="card-body">
                    <h1>All Stock losses</h1>

                    <a href="{{route('stock_loss.create')}}" style="float: right;" class="btn btn-primary">Add Stock loss</a>
                    <br><br>

                    <table class="table table-hover table-striped" id="loss">
                      <thead>
                        <th>Date created</th>  <th>Name</th> <th>Size</th> <th>Details</th> <th>Recorded by</th>
                      </thead>

                      <tbody>
                        @foreach($stock_loss as $losses)
                          <tr>
                            <td>{{$losses->created_at}}</td>  <td>{{$losses->name}}</td> <td>{{$losses->size}}</td> <td>{{$losses->description}}</td> <td>{{$losses->user->name}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
         
@endsection
 