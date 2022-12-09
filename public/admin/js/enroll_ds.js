	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	function generateRandomNo(email,reenroll) {
		var email = "hasta";
		$.ajax({
			url  : gemRandomNoUrl +'/'+email,
			type : 'GET',
			success : function(data) {
				var obj = JSON.parse(data);
				if (obj[0] == 'success') {
					if (reenroll) {
						getSignature(email,successCallBackForReEnroll,obj[1]);
					} else {
						getSignature(email,successCallBackForEnroll,obj[1]);
					}
					
				}
			}
		})
	}

	function getSignature(email,successCallBack,randomNo)
	{
		//var email = "hasta12@gmail.com";
		var signParams = "emsigneraction=sign\nsignaction=sign\nfilepath=\npanNumberParam=\nexpirycheck=false\nissuername=\ncertclass=1|2|3\ncerttype=ALL";
		var msgText = signParams + '\ndatatosign=' + email+'~'+randomNo;
		console.log(msgText);
		callApplet(msgText,successCallBack,randomNo);
	}

	function callApplet(msgText,successCallBack,randomNo)
	{
		if (connection == null) {
			alert('Error , Try Again');
		}
		connection.send(msgText);
		connection.onerror = (error) => {
			alert('Please check the server connection : ' + error);
			return failureCallBack(error);
		}

		connection.onmessage = (e) => {
			if (e.data.indexOf("subProtocol") == -1) {
				var respData = e.data;
				return successCallBack(respData,randomNo);
			}
		}
	}

	function successCallBackForEnroll(respData,randomNo)
	{
		var sigLast = respData.indexOf("CommonName");
		var sig = respData.substring(10,sigLast);
		var str = new String(sig);
		var seriallast = respData.indexOf("IssuerCommonName");
		var serial = respData.substring(44 + str.length, seriallast);
		serial = serial.replace(/\s/g,'');

		$.ajax({
			url  : enrollSigUrl,
			type : 'POST',
			data : {
				signature : sig,
				serial_no : serial,
				email : email,
				random_no : randomNo,
				re_enroll : false
			},
			success : function(data) {

			}
		})
	}


	function successCallBackForReEnroll(respData,randomNo) {
		var sigLast = respData.indexOf("CommonName");
		var sig = respData.substring(10, sigLast);
		var str = new String(sig);
		var seriallast = respData.indexOf("IssuerCommonName");
		var serial = respData.substring(44+str.length, seriallast);
		serial = serial.replace(/\s/g,'');
		$.ajax({
			url : enrollSigUrl,
			type : 'POST',
			data : {
				signature : sig,
				serial_no : serial,
				email : email,
				random_no : randomNo,
				re_enroll : true
			},
			success : function(data) {

			}

		});



	}

