@extends('layouts.main')
@section('content')
    <h1>Record a new sale</h1>
 
    <div class="card-box">
        <div class="card-body">                   
            
            <a class="btn btn-success" style="float: right;" href="{{route('main_sale.edit',$initiate_sale->id)}}">Details</a>
            <br><br>                 
            <div class="row col-md-12 "> 
                <div class="col-md-6 ">
                    <label>Select Item</label>
                    <select id="data" class="form-control datavalue">
                        <option></option>
                        @foreach($price_tags as $pricetags)
                          <option value="{{$pricetags->id}}" style="text-transform: uppercase;">{{$pricetags->stock->category->name}}   {{$pricetags->stock->name}}  {{$pricetags->barcode}} </option>
                        @endforeach
                    </select>
                    
                    <label>Quantity</label>
                    <input type="number" id="size" required="required" value="1" step="any" class="form-control">

                    <label>Discounted amount</label>
                    <input type="text" id="discount" value="0" class="form-control number">

                    <input type="hidden" id="mainsales_id" value="{{$initiate_sale->id}}">

                    <label>Shift</label>
                    <select id="workshift_id" class="form-control">
                        @foreach($shift as $shifts)
                          <option value="{{$shifts->id}}">{{$shifts->name}} [{{$shifts->description}}-{{date('Y-m-d',$shifts->date)}}]  </option>
                        @endforeach
                    </select> 

                    <label>Client details</label>
                    <input type="text" id="client" class="form-control">

                   
                    <br>
                    <button class="btn btn-success" id="btnsave">Save sale record</button>                           
                </div>
               <div class="col-md-6">
                    <h5 id="prices" style="color: green;"></h5> 
                    <span style="color: red; font-size: 30px;" id="total_amount"></span>

                    <br>
                    <label>Add payment</label>
                    <input type="text" id="payment_data" class="form-control next_number">
                    <br>
                    <button class="btn btn-success" id="save_payment" style="float: right;">Save payment</button>               
                </div>
            </div>
            <h3 id="display" style="color: green;"></h3>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th>Item</th> <th>Quantity</th> <th>Discount</th> <th>Amount</th>
                        </thead>
                        <tbody id="emp">                                    
                        </tbody>
                    </table>
                </div>
            </div>
         </div>
    </div>
      
@endsection

@push('scripts')
    <script type="text/javascript">
        $("#data").chosen();

        $("#save_payment").click(function() {
            $("#save_payment").text("Processing ...");
            $.ajax({
                type: "POST",
                url: "{{ route('sales_payment.store') }}",
            data: {
                amount: $("#payment_data").val(),
                mainsales_id: $("#mainsales_id").val(),
                _token: "{{Session::token()}}"
            },
            success: function(result){
                
                $('#payment_data').val(0);
               
                $("#save_payment").text(result);
                location.reload();

            }
          })
           
        });

        load_table();
        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 100;
        var $input = $('#data');

        //on keyup, start the countdown
        $input.on('keyup', function () {
          clearTimeout(typingTimer);
          typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
          clearTimeout(typingTimer);
        });


        $('#data').on('change',function(e){
            var data_value = $("#data").val();
            doneTyping ();
        });
   

        //Barcode scanner has "finished typing," do something
        function doneTyping () {
          //save the sale
          $('#display').text(" ");
            $.ajax({
                    type: "POST",
                    url: "{{url('/price_tags')}}",
                data: {
                     data: $("#data").val(),                           
                    _token: "{{Session::token()}}"
                },
                success: function(result){
                    $('#prices').html(result);
                  }
            })
        }
  
         $('#display').text(" ");
         $('#prices').text(" ");

         $("#btnsave").click(function() {
            $("#btnsave").html("Processing ...");
            $("#btnsave").attr('disabled','disabled');
            $('#display').text(" ");

            $.ajax({
                    type: "POST",
                    url: "{{ route('main_sale.store') }}",
                data: {
                    data: $("#data").val(),//this id the stock_id
                    size: $("#size").val(),                       
                    client: $("#client").val(),                       
                    discount: $("#discount").val(),                       
                    workshift_id: $("#workshift_id").val(),                        
                    mainsales_id: $("#mainsales_id").val(),
                    _token: "{{Session::token()}}"
                },
                success: function(result){
                    $('#display').html(result);
                    $("#size").val(1);
                    $('#discount').val(0);
                    typingTimer = setTimeout(donedisplaying,5000);
                    $("#emp > tr").remove();
                    load_table();

                    $("#btnsave").html("Save");
                    $("#btnsave").removeAttr('disabled');

                  }
              })  
            });

        function donedisplaying(){
            // $('#prices').text(" ");
         }

        function load_table(){
              $.ajax({ 
                url : "{{route('main_sale.show',$initiate_sale->id)}}",
                type : 'GET',
                dataType : 'JSON',
                success : function(data) {
                var sum_amount = 0;                
                    $(data).each(
                      function() {

                        $total = (this.amount*this.size) - (this.discount);

                          $('tbody#emp').append('<tr> <td>' + this.category_name+ '('+this.name+')</td><td>'+ this.size+ '</td> <td>'+this.discount+'</td>   <td>' + $total  + '</td> </tr>');

                          sum_amount = sum_amount + $total;
                      });
                    $("#total_amount").html("TOTAL UGX: "+sum_amount);
                    // console.log(sum_amount)
                },
                error : function(data) {} 
              });
          }
    </script>


@endpush
 