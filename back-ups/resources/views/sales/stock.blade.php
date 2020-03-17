@extends('layouts.main')

@section('content')
  <h1>Add new stock</h1> 
 
    <a href="{{route('stock.index')}}" style="float: right;" class="btn btn-primary">View Stock</a>
    <br><br>
    <div class="row col-md-12">
        <div class="col-md-6">
            <div class="card-box">
                <div class="card-body">
                     
                    <a href="#" id="show_add_cat" style="float: right;">Add new category</a>               
                   
                            <label>Choose category name</label>
                            <select id="category_id" autofocus="true" class="form-control">
                                <option></option>
                                @foreach($category as $categories)
                                  <option value="{{$categories->id}}" style="text-transform: uppercase;">{{$categories->name}}</option>
                                @endforeach
                            </select>

                            <label>Item name</label>
                            <input type="text" id="item_name" class="form-control">

                            <label>Re-Order level</label>
                            <input type="number" id="keeping_limit" value="0" step="any" class="form-control">

                            <label>Current stock size</label>
                            <input type="number" id="stock_size" value="0" class="form-control">

                            <label>Buying price</label>
                            <input type="text" id="buying_price" value="0" class="form-control number">

                            <label>Selling price</label>
                            <input type="text" id="selling_price" value="0" class="form-control next_number">

                            <label>Scan barcode (optional)</label>
                            <input type="text" id="barcode" class="form-control">

                            <br>
                            <button class="btn btn-primary" id="saveBtn">Save</button>                      
                            <input type="hidden" class="number">
                 </div>
            </div>
        </div>

        <div class="col-md-6 add_cat">
            <div class="card-box">
                <div class="card-body">
                    <h1>Add category</h1>
                             <label>Name</label>
                            <input type="text" id="name" autofocus="true" class="form-control">

                            <label>Selling Unit of measure</label>                          
                            <input type="text" id="unit" class="form-control">

                            <br><br>
                            <button class="btn btn-primary" id="save_category">Save</button>
                            <a href="{{route('category.index')}}" class="btn btn-success">Show categories</a>
                            <a href="" style="float: right;">Refresh</a>
                         <h3 id="display" style="color: green;"></h3>
                        <input type="hidden" class="number">
 
                </div>
            </div>
        </div>
        <p id="display" style="color: green;"></p>

    </div>
</div>
@endsection

@push('scripts')
<script>
    $(".add_cat").hide();

    $("#category_id").chosen();

    $("#show_add_cat").click(function(){
        $(".add_cat").show();
    });
</script>

<script>
       $("#saveBtn").click(function() {
         $("#saveBtn").text("Processing...");
         $("#display").text("");
         $("#saveBtn").attr("disabled","disabled");
         $.ajax({
                type: "POST",
                url: "{{ route('stock.store') }}",
            data: {
                  item_name: $("#item_name").val(),
                  keeping_limit: $("#keeping_limit").val(),
                  category_id: $("#category_id").val(),                           
                  stock_size: $("#stock_size").val(),                           
                  buying_price: $("#buying_price").val(),                           
                  selling_price: $("#selling_price").val(),
                  barcode: $("barcode").val(),                        
                _token: "{{Session::token()}}"
            },
                success: function(result){
                    $("#saveBtn").removeAttr("disabled");
                    $("#display").text(result);
                    $('#item_name').val(" ");
                    $("barcode").val(" ");
                    $("#saveBtn").text("Add new stock item");
                  }
        })
    });
  </script>


    <script>
       $("#save_category").click(function() {
        $("#save_category").text("Processing...");
        $("#display").text("");
        $.ajax({
                type: "POST",
                url: "{{ route('category.store') }}",
            data: {
                name: $("#name").val(),                              
                unit: $("#unit").val(),                              
                _token: "{{Session::token()}}"
            },
                success: function(result){
                    $("#display").text(result);
                    $('#name').val(" ")
                    $("#save_category").text("Add new category");
                  }
        })
    });
  </script>
@endpush


