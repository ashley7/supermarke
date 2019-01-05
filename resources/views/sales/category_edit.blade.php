@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Update category</h1>
                    <a href="{{route('stock.create')}}">Add stock</a>

                    <form method="POST" action="{{route('category.update',$read_category->id)}}">
                         @csrf
                        {{method_field("PATCH")}}
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" value="{{$read_category->name}}" class="form-control">                          
                            <br><br>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>                         
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
 