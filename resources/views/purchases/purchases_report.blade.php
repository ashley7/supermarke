@extends('layouts.main')

@section('content')
  <h3>Generate report on purchases</h3>
 
	 <div class="card-box">
        <div class="card-body">
			<form method="POST" action="/purchasesreport">	

	        	@csrf

	        	<label>From</label>
	        	<input type="date" name="from" class="form-control">

	        	<label>To</label>
	        	<input type="date" name="to" class="form-control">
	        	<br>
	        	<button type="submit" class="btn btn-success">Generate</button>

	        </form>
	    </div>
	</div>
@endsection