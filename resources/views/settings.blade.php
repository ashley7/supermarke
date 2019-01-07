@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="{{route('supplier.create')}}" class="btn btn-primary">Add Supplier</a>
            <a class="btn btn-primary" href="{{route('price_tag.create')}}">Add Price tags</a>
            <a class="btn btn-primary" href="{{route('stock.create')}}">Add Stock names</a>
            <a class="btn btn-primary" href="{{route('account.create')}}">Add Expense account</a>
            <a class="btn btn-primary" href="{{route('bank.create')}}">Add Bank</a>
            <a class="btn btn-primary" href="{{route('user.index')}}">Add new Users</a>
        </div>
    </div>
</div>
@endsection