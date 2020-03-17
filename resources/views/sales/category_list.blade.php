@extends('layouts.main')

@section('content')
        <h1 style="text-transform: uppercase;">List of Categories</h1>
            <div class="card-box">              

                <div class="card-body">
             

                    <a href="{{route('sales.create')}}" style="float: right;" class="btn btn-success">Create Sales</a>
                    <br><br>

                    <table class="table table-hover table-striped" id="example">
                        <thead>                          
                            <th>Name</th>                        
                            <th>Unit</th>                        
                            <th>Action</th>
                        </thead>

                        <tbody>
                        @foreach($read_category as $categories)
                          <tr>
                            <td style="text-transform: uppercase;">{{$categories->name}}</td>                   
                            <td style="text-transform: uppercase;">{{$categories->unit}}</td>                   
                            <td><a href="{{route('category.edit',$categories->id)}}">Edit</a></td>
                          </tr>

                        @endforeach                                                          
                                                           
                        </tbody>
                    </table>
                </div>

        
@endsection

 