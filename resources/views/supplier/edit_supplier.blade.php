@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Edit Supplier</h1>
                        <div class="col-md-6">
                          <form method="POST" action="{{route('supplier.update',$read_supplier->id)}}">
                               @csrf
                               {{method_field('PATCH')}}  
                                <label>Name *</label>
                                <input type="text" name="name" value="{{$read_supplier->name}}" class="form-control">

                                <label>Phone number *</label>
                                <input type="text" name="phone_number" value="{{$read_supplier->phone_number}}" class="form-control">   

                                <label>Address</label>
                                <input type="text" name="address" value="{{$read_supplier->address}}" class="form-control">   
                                <br>
                                <button type="submit" class="btn btn-primary" >Update</button>
                            </form>                           
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 