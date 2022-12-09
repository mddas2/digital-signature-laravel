$(document).ready(function(){
	$('#MPINForm').on('submit',function(e){
		alert('ok');
		e.preventDefault();
		var name = $('#name').val();
		var email = $('#email').val();
		var account_no = $('#account_number').val();
		var mpin = $('#mpin').val();
		var data = name + '||' + email + '||' + account_no + '||' + mpin;
		console.log('Appended Data is ::' + data);
		getSignature(data,gotSignature);
	});

	function gotSignature(respData) {
		var i_name = $("#name").val();
	    var i_email = $("#email").val();
	    var i_account_number = $("#account_number").val();
	    var i_mpin = $("#mpin").val();
	    var siglast = respData.indexOf("CommonName");
	    var sig = respData.substring(10, siglast);
	    var str = new String(sig);
	    var seriallast = respData.indexOf("IssuerCommonName");
	    var serial = respData.substring(44 + str.length, seriallast);
	    serial = serial.replace(/\s/g,'');
	    dd($respData);
	    if (sig == '') {
	    	alert('Invalid Sign Data');
	    	return false;
	    }

	    $.ajax({
	        url : "{{ URL::to('form_signing') }}",
	        type : "POST",
	        data : {
	            name : i_name,
	            email : i_email,
	            account_number : i_account_number,
	            mpin : i_mpin,
	            sign_data : sig,
	            serial_number : serial
	        },
	        success: function(data) {
	            //success
	            if(data == 'success') {
	            console.log("Success");
	            window.alert("Successfully transferred !!");
	            } else {
	                console.log("Error !!");
	            }

	        },
	        error: function(error) {
	            //error
	            console.log("Error");
	        }
	    });
	}
});