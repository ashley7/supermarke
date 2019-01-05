@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
            <div class="card">
                <div class="card-body">                   
                    <h1>Record sales</h1>
                    <a class="btn btn-primary" style="float: right;" href="{{route('main_sale.edit',$initiate_sale->id)}}">Print reciept</a>
                    <br><br>                 
                    <div class="row"> 
                        <div class="col-md-6">
                            <label>Select Item</label>
                            <select id="data" class="form-control datavalue">
                                <option></option>
                                @foreach($price_tags as $pricetags)
                                  <option value="{{$pricetags->id}}">{{$pricetags->stock->category->name}} ({{$pricetags->stock->name}})</option>
                                @endforeach
                            </select>
                            
                            <label>Quantity</label>
                            <input type="number" id="size" required="required" value="1" step="any" class="form-control">

                            <label>Discount</label>
                            <input type="text" id="discount" class="form-control number">

                            <input type="hidden" id="mainsales_id" value="{{$initiate_sale->id}}">

                            <label>Shift</label>
                            <select id="workshift_id" class="form-control">
                                @foreach($shift as $shifts)
                                  <option value="{{$shifts->id}}">{{$shifts->name}} [{{$shifts->description}}-{{$shifts->date}}]  </option>
                                @endforeach
                            </select>

                            

                           
                            <br>
                            <button class="btn btn-primary" id="btnsave">Save</button>                           
                        </div>
                        <div class="col-md-6">
                            <h5 id="prices" style="color: green;"></h5>   

                            <span style="color: red; font-size: 30px;" id="total_amount"></span>                        
                        </div>
                    </div>
                    <h3 id="display" style="color: green;"></h3>
                    <input type="hidden" class="next_number">

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <th>Item</th> <th>Quantity</th> <th>Amount</th>
                                </thead>
                                <tbody id="emp">                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("#data").chosen();

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

            $.ajax({
                    type: "POST",
                    url: "{{ route('main_sale.store') }}",
                data: {
                    data: $("#data").val(),
                    size: $("#size").val(),                       
                    discount: $("#discount").val(),                       
                    workshift_id: $("#workshift_id").val(),                        
                    class_price: $("#class_price").val(),
                    mainsales_id: $("#mainsales_id").val(),
                    _token: "{{Session::token()}}"
                },
                success: function(result){
                    $('#display').html(result);
                    $('#data').val(" ");
                    size: $("#size").val(1);
                    $("#data").show().focus();
                    typingTimer = setTimeout(donedisplaying,5000);
                    $("#emp > tr").remove();
                    load_table();

                    $("#btnsave").html("Save");
                    $("#btnsave").removeAttr('disabled');

                  }
              })  
            });

        function donedisplaying(){
            $('#display').text(" ");
            $('#prices').text(" ");
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
                          $('tbody#emp').append('<tr> <td>' + this.name+ '</td><td>'+ this.size+ '</td><td>' + this.amount+ '</td>'+' </tr>');
                          sum_amount = sum_amount + this.amount;
                      });
                    $("#total_amount").html("TOTAL UGX: "+sum_amount);
                    // console.log(sum_amount)
                },
                error : function(data) {} 
              });
          }
    </script>


@endpush
 