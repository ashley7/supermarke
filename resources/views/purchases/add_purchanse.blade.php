@extends('layouts.main')

@section('content')
<h1>Add Purchase</h1>           
            <a href="{{route('purchases.edit',$purchase->id)}}" style="float: right;" class="btn btn-success">Details</a>
            <br><br>
            <div class="card-box">
                <div class="card-body">                    
                    <div class="row col-md-6">
                        <div class="col-md-6">

                            <input type="hidden" id="parchase_id" value="{{$purchase->id}}">
                            <label>Choose Supplier *</label>
                            <select id="supplier_id" class="form-control">
                                @foreach($suppliers as $supplier)
                                  <option value="{{$supplier->id}}" style="text-transform: uppercase;">{{$supplier->name}}</option>
                                @endforeach
                            </select>
 
                            <label>Choose Stock *</label>
                            <select id="stock_id" class="form-control">
                                @foreach($stocks as $stock)
                                  <option value="{{$stock->id}}" style="text-transform: uppercase;"> {{$stock->category->name}}  ( {{$stock->name}} )</option>
                                @endforeach
                            </select>   

                            <label>Quantity</label>
                            <input type="number" id="quantity"  class="form-control">

                            <label>Unit Price</label>
                            <input type="text" id="unit_price"  class="form-control number">

                            <br>
                            <button class="btn btn-success" id="saveBtn">Save</button>
                            <a href="" style="float: right;">Refresh</a>
                        </div>

                        <div class="col-md-6">
                           <h3 id="total_amount" style="color: green;"></h3>
                           <br>
                           <label>Amount Paid</label>
                           <input type="text" id="amount_paid" class="form-control next_number">
                           <br>
                           <button id="save_payments" class="btn btn-success">Save</button>
                        </div>
                    </div>

                    <br><br>
                        

                        <table class="table" id="example">
                            <thead>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Unit price</th>
                                <th>Amount</th>
                            </thead>

                            <tbody id="emp">
                                
                            </tbody>

                        </table>
                    </div>
                </div>              
 
@endsection

@push('scripts')
  <script>
       $("#supplier_id,#stock_id").chosen();

       $("#saveBtn").click(function() {
            $("#saveBtn").text("Processing ...");
            $("total_amount").html("")
            $.ajax({
                    type: "POST",
                    url: "{{ route('purchases.store') }}",
                data: {
                    supplier_id: $("#supplier_id").val(),                              
                    stock_id: $("#stock_id").val(),                              
                    quantity: $("#quantity").val(),                              
                    unit_price: $("#unit_price").val(),                              
                    parchase_id: $("#parchase_id").val(),                             
                    _token: "{{Session::token()}}"
                },
                    success: function(result){
                        $("#emp > tr").remove();
                        load_table();
                        $("display").html(result)
                        $("#unit_price").val(" ")
                        $("#quantity").val(" ")
                        $("#stock_id").val(" ")
                        $("#saveBtn").text("Add new item");
                }
            })
        });


        $("#save_payments").click(function() {
            $("#save_payments").text("Processing ...");
             $.ajax({
                    type: "POST",
                    url: "{{ route('purchase_payment.store') }}",
                data: {
                    amount: $("#amount_paid").val(),                              
                    parchase_id: $("#parchase_id").val(),                             
                    _token: "{{Session::token()}}"
                },
                    success: function(result){
                        $("#amount_paid").val(" ")
                        $("#save_payments").text(result);
                         location.reload();
                }
            })
        });


    function load_table(){
          $.ajax({ 
            url : "{{route('purchases.show',$purchase->id)}}",
            type : 'GET',
            dataType : 'JSON',
            success : function(data) {
            var sum_amount = 0;                
                $(data).each(
                  function() {
                      $('tbody#emp').append('<tr> <td>'+this.category_name+'(' + this.name+ ')</td><td>'+ this.size+ '</td><td>' + this.amount+ '</td> <td> '+ this.size*this.amount +' </td></tr>');
                      sum_amount = sum_amount + (this.amount*this.size);
                  });

                $("#total_amount").html("TOTAL UGX: "+sum_amount);
            },
            error : function(data) {} 
          });
      }
  </script>

 

@endpush