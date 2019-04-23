@extends('layouts.main')

@section('content')
 
            <div class="card-box">               

                <div class="card-body">
                    <h1>Add Bank Transaction</h1>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                                <label>Transaction type</label>
                                <select id="transaction_type" class="form-control">
                                    <option></option>
                                    <option value="Deposit">Deposit</option>
                                    <option value="Withdraw">Withdraw</option>
                                </select>

                                <label>Amount</label>
                                <input type="text" name="amount" id="amount" step="any" class="form-control number">

                                <label>Voucher/Reciept Number</label>
                                <input type="text" id="voucher_number" class="form-control">

                                <label>Choose Bank</label>
                                <select class="form-control" id="bank_id" name="bank_id">
                                    <option></option>
                                    @foreach(App\Bank::all() as $banks)
                                      <option value="{{$banks->id}}">{{$banks->name}}</option>
                                    @endforeach
                                </select>

                                <label>Transacted by</label>
                                <select class="form-control" id="deposited_by" name="deposited_by">
                                    @foreach(App\User::all() as $users)
                                      <option value="{{$users->id}}">{{$users->name}}</option>
                                    @endforeach
                                </select>

                                <label>Date of transaction</label>
                                <input type="date" name="date" id="date" class="form-control">
                                <br>
                                <button class="btn btn-primary" id="saveBtn" type="submit">Save</button>
                                <br>
                                <span id="display"></span>
                         </div>
                    </div>
                </div>
            </div>

            
       
@endsection

@push('scripts')
<script type="text/javascript">
    $("#bank_id,#deposited_by,#transaction_type").chosen();
    $("#saveBtn").click(function() {
        $("#saveBtn").text("processing ...");
        $("#saveBtn").attr("disabled","disabled");
        $.ajax({
                type: "POST",
                url: "{{ route('bank_deposite.store') }}",
            data: {
                date: $("#date").val(),
                deposited_by: $("#deposited_by").val(),
                amount: $('#amount').val(),
                voucher_number: $('#voucher_number').val(),
                bank_id: $('#bank_id').val(),                     
                transaction_type: $('#transaction_type').val(),                     
                _token: "{{Session::token()}}"
            },
            success: function(result){
                // alert(result)
                $("#display").text(result)
                $("#saveBtn").removeAttr("disabled");
                $("#saveBtn").text("Add new deposit");
                $('#amount').val(" ")
              }
        })
    });
</script>
@endpush