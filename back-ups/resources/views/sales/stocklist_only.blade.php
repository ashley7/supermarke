@extends('layouts.main')

@section('content')
<h1>All current stock</h1>
 
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
                            <th>Action</th>                           
                        </thead>

                        <tbody>  

                        @php 

                          $total_value = 0; 


                        @endphp
                        @foreach($stock as $stock_details)
                          <?php 
                             $price_tags = App\PriceTag::all()->where('stock_id',$stock_details->id)->last();


                            $buying = $selling = 0;                            
                             if (!empty($price_tags)) {
                                 $buying = $price_tags->buying_price;
                                 $selling = $price_tags->salling_price;
                             }

                            ?>
                              <tr>
                                 <td>{{$stock_details->id}}</td>
                                 <td>{{$stock_details->category->name}} ({{$stock_details->name}})</td>
                                 <td>{{number_format($buying)}}</td>
                                 <td>{{number_format($selling)}}</td>
                                <td><a class="btn btn-primary" href="{{route('stock.edit',$stock_details->id)}}">Edit</a></td>
                               </tr> 
                            @endforeach
 
                            <th>Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tbody>
                    </table>  

               

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 