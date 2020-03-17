@extends('layouts.main')

@section('content')
            <h1>Update category</h1>
 
<div class="card-box">
    <div class="card-body">

        <a href="{{route('stock.create')}}">Add stock</a>

        <form method="POST" action="{{route('category.update',$read_category->id)}}">
             @csrf
            {{method_field("PATCH")}}
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" value="{{$read_category->name}}" class="form-control">   

                <label>Selling Unit of measure</label>                          
                <input type="text" name="unit" value="{{$read_category->unit}}" class="form-control">

                <br>
                <button class="btn btn-success" type="submit">Update</button>
            </div> 
        </form>                        
     </div>
</div>      
@endsection
 