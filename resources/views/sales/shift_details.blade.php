@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 style="text-transform: uppercase;">{{$work_shifts->name}}, by {{$work_shifts->description}}, on {{date("d-m-Y",$work_shifts->date)}}</h3>

                    <a href="" style="float: right;">Refresh</a>
 
                    <ul class="nav nav-tabs">
                      <li><a data-toggle="tab" class="btn btn-success" href="#sales">Sales</a></li>
                      <li class="active"><a data-toggle="tab" class="btn btn-info" href="#stock">Current Stock</a></li>
                      <!-- <li><a data-toggle="tab" href="#bottles" class="btn btn-primary">Spoilt bottles</a></li> -->
                    </ul>

                <div class="tab-content">
                    <div id="sales" class="tab-pane fade in">
                      <br>
                        <table class="table table-hover table-striped" id="sales_table">
                            <thead>
                                
                                <th>Date</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Buying price</th>
                                <th>Selling price</th>
                                <th>Discount</th>
                                <th>Amount</th>
                                <th>Gross Profit</th>
                            </thead>

                            <tbody>
                                <?php $sum = $sum_profit =  $sum_discount = 0; ?>
                                @foreach($sales as $sale)
                                <?php
                                  $main_sale = ($sale->amount * $sale->size)-$sale->discount;
                                  $profit = $main_sale - ($sale->buying_price * $sale->size);

                                  $sum_profit = $sum_profit + $profit;
                                  $sum = $sum + $main_sale;
                                  $sum_discount = $sum_discount + $sale->discount;
                                 ?>
                                  <tr>
                                      <td>{{$sale->created_at}}</td>
                                      <td>{{$sale->stock->category->name}} ({{$sale->stock->name}})</td>
                                      <td>{{$sale->size}} {{$sale->stock->category->unit}}</td> 
                                      <td>{{number_format($sale->buying_price)}}</td>
                                      <td>{{number_format($sale->amount)}}</td>
                                      <td>{{number_format($sale->discount)}}</td>
                                      <td>{{number_format($main_sale)}}</td>
                                      <td>{{number_format($profit)}}</td>
                                  </tr>
 
                                @endforeach

                                <tr>                                   

                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{number_format($sum_discount)}}</th>
                                <th>{{number_format($sum)}}</th>
                                <th>{{number_format($sum_profit)}}</th>
                                </tr>
                            </tbody>
                        </table>
                             
                        </div>

                        <div id="stock" class="tab-pane fade in active">
                          <br>
                             <table class="table table-hover table-striped" id="stock_table">
                                 <thead>
                                    <th>#</th> <th>Name</th> <th>Old stock</th> <th>New stock</th> <th>Initial stock</th> <th>Total Sold</th> <th>Stock left</th> <th>Value</th>
                                 </thead>

                                 <tbody>
                                  <?php $sum_value = 0; ?>
                                     @foreach($brands as $brand)
                                     <?php
                                        $initial_stock = 0;
                                        $sum_sold = 0;
                                        $record_check = App\ShiftStock::all()->where('stock_id',$brand->stock_id)->where('workshift_id',$work_shifts->id)->last(); 

                                        if (!empty($record_check)) {
                                          $sum_sold = App\Sale::all()->where('workshift_id',$work_shifts->id)->where('stock_id',$brand->stock_id)->sum('size');

                                           $initial_stock = $record_check->old_stock + $record_check->new_stock;
                                        }

                                        $stock_price = App\PriceTag::all()->where('stock_id',$brand->stock->id)->last();
                                        $buyingprice = 0;
                                        if (!empty($stock_price)) {
                                          $buyingprice = $stock_price->buying_price;
                                        }

                                        $stock_left = $initial_stock - $sum_sold;

                                        $stock_value = $stock_left * $buyingprice;

                                        $sum_value = $sum_value + $stock_value;

                                        
                                    ?>
                                    @if(!empty($record_check))
                                     <tr>
                                       <td>{{$brand->stock->id}}</td>
                                       <td>{{$brand->stock->category->name}} ({{$brand->stock->name}})</td>

                                       <td contenteditable="true" id="{{$brand->stock_id}}*old_stock">{{$record_check->old_stock}}</td>

                                       <td contenteditable="true" id="{{$brand->stock_id}}*new_stock">{{$record_check->new_stock}}</td>
                                       <td>{{$initial_stock}}</td>
                                       <td>{{$sum_sold}}</td>
                                       <td>{{$stock_left}}</td>
                                       <td>{{number_format($stock_value)}}</td>
                                   </tr>

                                   @else

                                    <tr>
                                       <td>{{$brand->stock->id}}</td>
                                       <td>{{$brand->stock->category->name}} ({{$brand->stock->name}})</td>
                                       <td contenteditable="true" id="{{$brand->stock_id}}*old_stock"></td>
                                       <td contenteditable="true" id="{{$brand->stock_id}}*new_stock"></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                       <td></td>
                                   </tr>
                                   @endif
                                @endforeach

                                <tr>
                                  <th>Total</th> <th></th> <th></th> <th></th> <th></th> <th></th> <th></th> <th>{{number_format($sum_value)}}</th>
                                </tr>
                              </tbody>
                          </table>

                             <input type="hidden" id="shift" value="{{$work_shifts->id}}">
                        </div>

                        <div id="bottles" class="tab-pane fade in">
                          <br>
                            <table class="table table-hover table-striped" id="loss">
                              <thead>
                                <th>Date created</th>  <th>Name</th> <th>Size</th> <th>Details</th> <th>Recorded by</th>
                              </thead>

                              <tbody>
                                @foreach($stock_loss as $losses)
                                  <tr>
                                    <td>{{$losses->created_at}}</td>  <td>{{$losses->name}}</td> <td>{{$losses->size}}</td> <td>{{$losses->description}}</td> <td>{{$losses->user->name}}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">      
      $("td[contenteditable=true]").blur(function() {
         $.ajax({
          
                type: "POST",
                url: "{{ route('shift_stock.store') }}",
            data: {
                information: $(this).attr("id"),
                stock_value: $(this).text(),
                shift: $("#shift").val(),
                _token: "{{Session::token()}}"
            },
          success: function(result){
            if (result) {
              console.log(result);
            }           
                
          },
          
        })
    });
  </script>


     <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
     <script>
       $(document).ready(function() {
              $('#sales_table,#stock_table,#loss').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    {
                        extend: 'excel',
                     },
                    {
                        extend: 'pdf',
                     },
                    {
                        extend: 'csv',
                        messageTop: null
                    }
                ]
            } );
        } );
    </script>
@endpush