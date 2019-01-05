@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('price_tag.index')}}" style="float: right;" class="btn btn-primary">View Tags</a>
                    <br>

                    <h1>Add price tags</h1>
                    
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{route('price_tag.store')}}">
                        @csrf
                        <div class="col-md-6">
                            <label>Item name</label>
                            <select name="stock_id" id="stock_id" class="form-control">
                                @foreach($stock as $stock_value)
                                  <option value="{{$stock_value->id}}" style="text-transform: uppercase;">{{$stock_value->category->name}} ({{$stock_value->name}})</option>
                                @endforeach
                            </select>
                            <label>Buying Price</label>
                            <input type="text" name="buying_price" class="form-control next_number">

                            <label>salling Price</label>
                            <input type="text" name="salling_price" class="form-control number">
                                                     
                            <br>
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                         
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
  <script>
      $("#stock_id").chosen();
  </script>
@endpush

 