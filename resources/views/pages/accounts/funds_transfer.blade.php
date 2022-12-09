@extends('master')

@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
            @include('message.flash')
	        <div class="main-card mb-3 card">
	            <div class="card-header">Funds Transfer</div>
	            <div class="card-body">
	            	<form action="{{ route('funds_transfer_add')}}" method="POST" id="fundsTransfer">
                        {{csrf_field()}}
                        <input name="signature" type="hidden" class="signedData">
                        <div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Select Payee</label>
                        	<select class="form-control" name="payee" id="payee">
                                @foreach($payee as $payee_list)
                                    <option value="{{$payee_list->id}}">{{$payee_list->name}}-{{$payee_list->account_no}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Transferred To :</label>
                            <input name="name" placeholder="Transferred To" type="text" class="form-control" id="name" autocomplete="off">
                        </div>
                     	<div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Account No :</label>
                        	<input name="account_no" placeholder="Select Account Number" type="text" class="form-control" id="account_no" autocomplete="off">
                        </div>
                        <div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Amount :</label>
                        	<input name="amount" placeholder="Add amount to be transferred" type="text" class="form-control" id="amount" autocomplete="off">
                        </div>
                         <div class="position-relative form-group">
                        	<label for="exampleEmail" class="">Remarks</label>
                        	<input name="remarks" placeholder="Remarks" type="textarea" class="form-control" id="remarks" autocomplete="off">
                        </div>
                     	<button class="btn btn-primary" type="submit" id="formSigning">Transfer Fund</button>
                	</form>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
@section('js_scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#formSigning').click(function(e){
            e.preventDefault();
            generateRandomNo(uniqueId,channelId,gemRandomNoUrl,checkRandomNo);
        });

        function checkRandomNo(randomNo) {
            if (randomNo[0] == 'success') {
                var payee = $('#payee').val();
                var name = $('#name').val();
                var account_no = $('#account_no').val();
                var amount = $('#amount').val();
                var remarks = $('#remarks').val();
                var data = payee + '||' + name + '||' + account_no + '||' + amount + '||' + remarks;
                getSignatureForFormSigning(data,uniqueId,gotSignature,randomNo[1]);
            } else {
                alert('error');
            }

        }

        function gotSignature(respData) {
            console.log(respData);
            var sigLast = respData.indexOf("CommonName");
            var sig = respData.substring(10,sigLast);
            var str = new String(sig);
            console.log(str);
        	formSigning(sig);
	}

        function formSigning(sig) {
            $.ajax({
                url : "{{ URL::to('ds/form_signing')}}",
                type : "POST",
                data : {
                    signature : sig
                },
                success : function(response) {
                    var obj = JSON.parse(response);
                    console.log(obj);
                    if (obj.status == "success") {
                        $('.signedData').val(obj.signedData.trim());
                        alert('succcess');
                        $('#fundsTransfer').submit();
                    } else {
                        alert('error');
                    }
                }
            });
        }

        // function gotSignature (respData) {
        //     var sigLast = respData.indexOf("CommonName");
        //     var sig = respData.substring(10,sigLast);
        //     var str = new String(sig);
        //     $.ajax({
        //         url : "{{ URL::to('ds/form_signing')}}",
        //         type : 'POST',
        //         data : {
        //             signature : sig
        //         },
        //         success : function (response) {
        //             var obj = JSON.parse(response);
        //             if (obj.status[0] == "success") {
        //                 alert('succcess');
        //                 $('#fundsTransfer').submit();
        //             } else {
        //                 alert('error');
        //             }
        //         }
        //     });
        // }
    });
</script>
@endsection
