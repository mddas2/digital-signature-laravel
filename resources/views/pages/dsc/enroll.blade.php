@extends('master')

@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
	        <div class="main-card mb-3 card">
	      
	            <div class="card-header">Enroll DSC</div>
	            <div class="card-body"><h5 class="card-title">Enroll Digital Signature Certificate</h5><hr>Click the button to enroll your own digital signature cerficate in the system.<br><br>
	            	@if (auth()->user()->is_enrolled != 1)
	                	<button class="btn btn-warning" id="enroll_dsc">ENROLL</button>
                	@else 
                		<span class="btn btn-success">User has been successfully enrolled. Make sure to confirm the enrolled user in Emas Maker and Checker Panel</span>
                	@endif
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
@section('js_scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#enroll_dsc').click(function(){
			generateRandomNo(uniqueId,channelId,gemRandomNoUrl,checkRandomNo);
		});	

		function checkRandomNo(randomNo)
		{
			if (randomNo[0] == 'success') {
				getSignature(uniqueId,successCallBackForEnroll,randomNo[1]);
			} else {
				alert('error');
			}
		}

		function successCallBackForEnroll(respData)
		{
			console.log(respData);
			var sigLast = respData.indexOf("CommonName");
			var sig = respData.substring(10,sigLast);
			var str = new String(sig);
			$.ajax({
				url : "<?php echo URL::to("ds/enroll_signature");?>",
				type : 'POST',
				data : {
					signature : sig,
					unique_id : uniqueId
				},
				success : function (data) {
					var obj = JSON.parse(data);
					console.log(obj);
					alert(obj.msg);
					// if (obj.success = 1) {
					// 	//location.reload();
					// }
				}
			})
		}
	});
</script>
@endsection