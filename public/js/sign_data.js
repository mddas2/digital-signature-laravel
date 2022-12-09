function getSignature(uniqueId,successCallBack,randomNo)
{
	var signParams = "emsigneraction=sign\nsignaction=sign\nfilepath=\npanNumberParam=\nexpirycheck=false\nissuername=\ncertclass=1|2|3\ncerttype=ALL";
	var msgText = signParams + '\ndatatosign=' + uniqueId+'~'+randomNo; 
	callApplet(msgText,successCallBack,randomNo);
}

function signPdf(inputFileUrl, id, successCallback, failureCallback) {
    var signParams = "emsigneraction=pdfsign\n" +
        "tbs=" + inputFileUrl +
        "\noutputpath=" +
        "\nsignaction=3\n" +
        "certtype=ALL\n" +
        "expirycheck=false\n" +
        "issuername=\n" +
        "signtype=detached\n" +
        "coordinate=400,100,500,150\n" +
        "pageno=all\n" +
        "reason=test\n" +
        "location=Kathmandu";
    callApplet(signParams,id , successCallback, failureCallback);
}

function getSignatureForFormSigning(data, uniqueId,successCallBack,randomNo)
{
	var signParams = "emsigneraction=sign\nsignaction=sign\nfilepath=\npanNumberParam=\nexpirycheck=false\nissuername=\ncertclass=1|2|3\ncerttype=ALL";
	//var msgText = signParams + '\ndatatosign=' + data + '||' + uniqueId+'~'+randomNo;
	var msgText = signParams + '\ndatatosign=' + data + '||' + uniqueId;
	callApplet(msgText,successCallBack,randomNo);
}

function callApplet(msgText , id ,successCallBack,randomNo)
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
			return successCallBack(respData,id);
		}
	}
}