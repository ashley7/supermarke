@extends('layouts.main')

@section('content')
<h1>All current stock status</h1>
 
            <div class="card-box">

                <div class="card-body">
                    

                    <a href="{{route('stock.create')}}" style="float: right;" class="btn btn-primary">Create Stock</a>
                    <br><br>

                    <table class="table table-hover table-striped" id="example">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Buying price</th>
                            <th>Selling price</th>
                            <th>Re-order level</th>
                            <th>No. of sales</th>
                            <th>Quantity left</th>                           
                            <th>Stock Value</th>
                            <th>Action</th>                           
                        </thead>

                        <tbody>  

                        @php 

                          $total_value = 0; 


                        @endphp
                        @foreach($stock as $stock_details)
                            <?php 
                             $price_tags = App\PriceTag::all()->where('stock_id',$stock_details->id)->last();

                             
                             // get quantity left
                             $work_shift = App\WorkShift::all()->last();
                             $quantity_left = App\Sale::where('stock_id',$stock_details->id)->where('workshift_id',$work_shift->id)->sum('size');
                             $shift_stock = App\ShiftStock::all()->where('stock_id',$stock_details->id)->last();

                            // read curent price for item
                            $buying = $selling = $old_stock = $all_stock = 0;                            
                             if (!empty($price_tags)) {
                                 $buying = $price_tags->buying_price;
                                 $selling = $price_tags->salling_price;
                             }

                             if (!empty($shift_stock)) {
                                 $all_stock = $shift_stock->old_stock + $shift_stock->new_stock;
                                  
                             }

                             $stock_left = $all_stock - $quantity_left;
                             $stock_value =  $stock_left * $buying;

                             $total_value = $total_value + $stock_value;

                             ?>
                              <tr>
                                 <td>{{$stock_details->id}}</td>
                                 <td>{{$stock_details->category->name}} ({{$stock_details->name}})</td>
                                 <td>{{number_format($buying)}}</td>
                                 <td>{{number_format($selling)}}</td>
                                 <td>{{$stock_details->keeping_limit}}</td>
                                 <td>{{$stock_details->sales->count()}}</td>
                                 <td>
                                    @if($stock_left <= $stock_details->keeping_limit)
                                      <span style="color: red">{{number_format($stock_left)}} </span>
                                      @else
                                      {{number_format($stock_left)}}
                                    @endif  
                                 </td>                                
                                 
                                 <td>{{number_format($stock_value)}}</td>
                                 <td><a class="btn btn-primary" href="{{route('stock.edit',$stock_details->id)}}">Edit</a></td>
                               </tr> 
                            @endforeach
 
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>                            
                            <th></th>
                            <th>{{number_format($total_value)}}</th>
                            <th></th>                       
                        </tbody>
                    </table>  

               

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 