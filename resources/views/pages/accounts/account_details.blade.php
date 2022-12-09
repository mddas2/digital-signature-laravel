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
	                            <th>View</th>
	                        </tr>
                        </thead>
                        <tbody>
		                    <tr>
		                        <td>{{$data->created_at}}</td>
		                        <td>{{$payee_list[$data->payee_id]}}</td>
		                        <td>{{$data->name}}</td>
		                        <td>{{$data->account_no}}</td>
		                        <td>{{$data->remarks}}</td>
		                        <td>
	                        	<?php
                            $uniqueID = auth()->user()->unique_id;
                    				$tbsData = $data->payee_id . '||' .$data->name . '||' .$data->account_no. '||' .$data->amount . '||' .$data->remarks .'||'.$uniqueID ;
                            
			    $sign = trim(preg_replace('/\s+/', ' ', $data->signature));
                    				$emasResponse = verifyFormDataWithEmas($tbsData, $sign);
                    				if($emasResponse['status'] == 'exception'){ ?>
                        				<div class="alert alert-danger"> 
                        					<span  style="color:#444;"> Data Modified !!</span>
                        					<br /> Signature doesn't match.<br/>
                            				<b>Previously signed by: </b>
                            				<br/>
                            				{{$emasResponse['signer']['commonName']}},
                       					 	{{$emasResponse['signer']['email']}} 
                   					 	</div>
                            		<?php }elseif($emasResponse['status'] == 'success'){ ?>
                              			<div class="alert alert-success">
                              				<b>Digitally Signed by:</b><br/>
                                			{{$emasResponse['signer']['commonName']}}
                                			<br/>Email:<br/>
                                			{{$emasResponse['signer']['email']}}
                                		</div>
                                	<?php  }else{ ?>
                                   		<p>Something worng verifying the signature.</p>
                                   <?php } ?>
                               	</td>
		                    </tr>
                        </tbody>
                    </table>
                </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
