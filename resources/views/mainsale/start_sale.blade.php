@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
            <div class="card">
                <div class="card-body">                   
                    <h1>Record sales</h1>
                    <a class="btn btn-primary" style="float: right;" href="{{route('main_sale.edit',$initiate_sale->id)}}">Print reciept</a>                 
                    <div class="row"> 
                        <div class="col-md-6">
                            <label>Select Item</label>
                            <select id="data" class="form-control datavalue">
                                <option></option>
                                @foreach($price_tags as $pricetags)
                                  <option value="{{$pricetags->barcode}}">{{$pricetags->name}}</option>
                                @endforeach
                            </select>



                            <label>Place the Computer Cursor here</label>
                            <input type="text" id="data" required="required" autofocus="true" class="form-control data">
                            <label>Quantity</label>
                            <input type="number" id="size" required="required" value="1" step="any" class="form-control">

                            <input type="hidden" id="mainsales_id" value="{{$initiate_sale->id}}">
                            <label>Shift</label>
                            <select id="workshift_id" class="form-control">
                                @foreach($shift as $shifts)
                                  <option value="{{$shifts->id}}">{{$shifts->name}} [{{$shifts->description}}-{{$shifts->date}}]  </option>
                                @endforeach
                            </select>
                            <input type="hidden" class="number">
                            <br>
                            <button class="btn btn-primary" id="btnsave">Save</button>                           
                        </div>
                        <div class="col-md-6">
                            <h1 id="prices" style="color: green;"></h1>   

                            <span style="color: red; font-size: 30px;" id="total_amount"></span>                        
                        </div>
                    </div>
                    <h3 id="display" style="color: green;"></h3>
                    <input type="hidden" class="number">

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
        // $("#data").chosen();

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
                     // typingTimer = setTimeout(save_beer,3000);                              
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

    <script>
        
    $("#data").click(function() {
        var data_value = $("#data").val();
        $(".data").val(data_value);
      doneTyping ();
    });
    </script>
@endpush
 