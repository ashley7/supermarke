@extends('layouts.main')

@section('content')
 
    <a href="{{route('stock.show','edit_stock')}}" style="float: right;" class="btn btn-success">View Stock</a>
    <br><br>
 
       
    <div class="card-box">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card-body">
            <form method="POST" action="{{route('stock.update',$read_stock->id)}}">
                @csrf
                {{method_field("PATCH")}}
                <h1>Edit stock name</h1>  
                <label>Item name</label>
                <input type="text" name="item_name" value="{{$read_stock->name}}" class="form-control">

                <label>Re-Order level</label>
                <input type="number" name="keeping_limit" value="{{$read_stock->keeping_limit}}" class="form-control">

                <label>Buying price</label>
                <input type="number" name="buying_price" value="{{$buying_price}}" class="form-control">

                <label>Saling price</label>
                <input type="number" name="saling_price" value="{{$saling_price}}" class="form-control">

                <br>
                <button class="btn btn-success" id="saveBtn">Update</button>                      
            </form>
         </div>
           
        </div>
   
 
@endsection
