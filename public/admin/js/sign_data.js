function getSignature(uniqueId,successCallBack,randomNo)
{
	// alert(uniqueId);
	// alert(randomNo);
	//var email = "hasta12@gmail.com";
	var signParams = "emsigneraction=sign\nsignaction=sign\nfilepath=\npanNumberParam=\nexpirycheck=false\nissuername=\ncertclass=1|2|3\ncerttype=ALL";
	var msgText = signParams + '\ndatatosign=' + uniqueId+'~'+randomNo;
	console.log(msgText);
	callApplet(msgText,successCallBack,randomNo);
}

function getSignatureForFormSigning(data, uniqueId,successCallBack,randomNo)
{
	var signParams = "emsigneraction=sign\nsignaction=sign\nfilepath=\npanNumberParam=\nexpirycheck=false\nissuername=\ncertclass=1|2|3\ncerttype=ALL";
	var msgText = signParams + '\ndatatosign=' + data + '||' + uniqueId+'~'+randomNo;
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
			return successCallBack(respData);
		}
	}
}