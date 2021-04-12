@extends('layouts.main')

@section('content')
  <h1>{{$title}}</h1>
  <div class="card-main">
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="example">

          <thead>
            <th>Item</th>
            <th>Quantity sold</th>
            <th>Discounts</th>
            <th>Unit Price</th>
            <th>Amount</th>
          </thead>

          <tbody>

            @foreach($stocks as $stock)

            <?php

              $quantity = App\AdhocReport::quantitySold($from,$to,$stock->id);

              $discounts = App\AdhocReport::discounts($from,$to,$stock->id);

              $discounts = App\AdhocReport::discounts($from,$to,$stock->id);

              $unit_price = $stock->priceTag->salling_price;

              $amount = App\AdhocReport::amount($from,$to,$stock->id);

             ?>
              <tr>
                <td> {{$stock->category->name}} ({{$stock->name}})</td>
                <td>{{$quantity}}</td>
                <td>{{$discounts}}</td>
                <td>{{number_format($unit_price)}}</td>
                <td>{{number_format($amount)}}</td>
              </tr>

            @endforeach

          </tbody>

        </table>
      </div>
         
    </div>
  </div>       
@endsection