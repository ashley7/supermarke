@extends('layouts.main')

@section('content')
 
<div class="card-box">              
    <div class="card-body">
        <form method="POST" action="{{route('sales_report.store')}}">
            @csrf

            <label>From</label>
            <input type="date" name="from" class="form-control">

            <label>To</label>
            <input type="date" name="to" class="form-control">
            <br>
            <button class="btn btn-primary" type="submit">Generate</button>
        </form>
    </div>
</div>    
 
@endsection
@push('scripts')

<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />

    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>

@endpush