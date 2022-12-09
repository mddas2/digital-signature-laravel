@extends('master')
@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
            @include('message.flash')
	        <div class="main-card mb-3 card">
	            <div class="card-header">Add Payee</div>
	            <div class="card-body">
	            	<form action="{{ route('add_payee_detail')}}" method="POST">
                        {{csrf_field()}}
                        <div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Name</label>
                        	<input name="name" placeholder="Name" type="text" class="form-control">
                        </div>
                         <div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Account No :</label>
                        	<input name="account_no" placeholder="Account Number" type="text" class="form-control">
                        </div>
                         <div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Remarks</label>
                        	<input name="remarks" placeholder="Remarks" type="textarea" class="form-control">
                        </div>
                     	<button class="btn btn-primary" type="submit">SUBMIT</button>
                	</form>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection