@extends('master')

@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
	        <div class="main-card mb-3 card">
	            <div class="card-header">Re-Enroll DSC</div>
	            <div class="card-body"><h5 class="card-title">Re-Enroll Digital Signature Certificate</h5><hr>Re-Enroll your signed certificate if it's expired or to update.<br><br>
	                <button class="btn btn-warning" id="reenroll_ds">RE-ENROLL</button>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
@section('js_scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#reenroll_ds').click(function(){
            generateRandomNo(uniqueId,channelId,gemRandomNoUrl,checkRandomNo);
        }); 

        function checkRandomNo(randomNo) 
        {
        	if (randomNo[0] == 'success') {
        		getSignature(uniqueId,successCallBackForReEnroll,randomNo[1]);
        	} else {
        		alert('error');
        	}
        }

        function successCallBackForReEnroll(respData)
        {
            var sigLast = respData.indexOf("CommonName");
            var sig = respData.substring(10,sigLast);
            var str = new String(sig);
            $.ajax({
                url : "<?php echo URL::to("ds/re_enroll_signature");?>",
                type : 'POST',
                data : {
                    signature : sig,
                    unique_id : uniqueId
                },
                success : function (data) {
                    if (data == true) {
                        alert('User has been successfully re-enrolled');
                    } else {
                        alert('User cannot be re-enrolled');
                    }
                }
            });
        }
    });
</script>
@endsection