@extends('layouts.main')

@section('content')
    <h1>{{$title}}</h1>
    <div class="card-box">
        <div class="card-body">
            <table class="table table-hover table-striped" id="example">
                <thead>
                    <th>Name</th>
                    <th>Buying price</th>
                    <th>Selling price</th>
                    <th>No. of sales</th>
                    <th>Quantity In</th>                           
                    <th>Quantity Sold <br> In time range</th>                           
                    <th>Quantity <br>left today</th>                           
                    <th>Stock Value</th>
                                            
                </thead>

                <tbody>
                  @foreach($stockItems as $stock)

                  <?php
                    $price_tags = App\PriceTag::where('stock_id',$stock->id)->get();

                    if ($price_tags->count() == 0) continue;

                    $price_tag = $price_tags->last();

                    $quantity = App\Sale::where('stock_id',$stock->id)->whereBetween('created_at',[$from,$to])->get();

                    $shift_stock = App\ShiftStock::where('stock_id',$stock->id)->get();

                    if ($shift_stock->count() == 0) continue;

                    $currentShiftStock = $shift_stock->last(); 

                    $stockOut =  App\Sale::where('stock_id',$stock->id)->sum('size');

                    $stockIn = $currentShiftStock->old_stock + $currentShiftStock->new_stock;

                    $left = $stockIn - $stockOut;

                   ?>

                    <tr>
                        <td>{{$stock->category->name}} ({{$stock->name}})</td>
                        <td>{{number_format($price_tag->buying_price)}}</td>
                        <td>{{number_format($price_tag->salling_price)}}</td>
                        <td>{{$quantity->count()}}</td>
                        <td>{{$stockIn}}</td>
                        <td>{{$quantity->sum('size')}}</td>                        
                        <td>{{$left}}</td>
                        <td>{{number_format($left * $price_tag->buying_price)}}</td>
                        
                    </tr>

                  @endforeach                  
                
                </tbody>
            </table>  

        </div>
    </div>
      
@endsection
 