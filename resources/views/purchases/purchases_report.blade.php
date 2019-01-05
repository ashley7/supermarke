@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">        
        <div class="col-md-12"> 
        	 <div class="card">
                <div class="card-body">

			        <h3>Generate report on purchases</h3>

			        <form method="POST" action="/purchasesreport">	

			        	@csrf

			        	<label>From</label>
			        	<input type="date" name="from" class="form-control">

			        	<label>To</label>
			        	<input type="date" name="to" class="form-control">
			        	<br>
			        	<button type="submit" class="btn btn-primary">Generate</button>

			        </form>

			        </div>
			    </div>
			</div>
		</div>
	</div>

@endsection