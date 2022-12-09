@extends('master')

@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
	        <div class="main-card mb-3 card">
	            <div class="card-header">Account Summary</div>
	            <div class="card-body">
	            	<h5 class="card-title">List Of Transactions</h5>
                    <table class="mb-0 table table-bordered table-hover">
                        <thead>
	                        <tr>
	                            <th>Date</th>
	                            <th>Payee</th>
	                            <th>Transferred To</th>
	                         	<th>Account Number</th>
	                            <th>Remarks</th>
	                            <th>Action</th>
	                        </tr>
                        </thead>
                        <tbody>
                        	@foreach($funds_transfered as $funds)
		                    <tr>
		                        <td>{{$funds->created_at}}</td>
		                        <td>{{$payee_list[$funds->payee_id]}}</td>
		                        <td>{{$funds->name}}</td>
		                        <td>{{$funds->account_no}}</td>
		                        <td>{{$funds->remarks}}</td>
		                        <td><a href="{{route('account_details',$funds->id)}}" class="btn btn-default">View</td>
		                    </tr>
		                    @endforeach
                        </tbody>
                    </table>
                </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
