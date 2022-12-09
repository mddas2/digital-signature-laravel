var ListeningPort = 8080;
var PortList = [8080];
var connection;
var errorCount = 0;
var index = 0;

function startConnection() 
{
	for (var i = 0; i< PortList.length; i++) {
		setConnectionPort(PortList[i]);
	}
}

function setConnectionPort(port) 
{
	if ("WebSocket" in window) {
		setTimeout(function(){
			var ws = new WebSocket("wss://127.0.0.1:"+port);
			console.log(ws);
			ws.onopen = () => {
				console.log('Connection Started')
			};
			
			ws.onmessage = (evt) => {
				try {
					connection = ws;
					console.log('Connection set. calling back');
					connectionSet();
				} catch (err) {
					console.log(err);
				}
			};

			ws.onerror = (err) => {
				failedToConnect();
			}

		},1);
	}
}		

function connectionSet()
{
	console.log("Connection Successful");
}

function failedToConnect()
{
	console.log("Connection Failed");
}

function generateRandomNo(uniqueId,channelId,gemRandomNoUrl,callBack)
{
	$.ajax({
		url  : gemRandomNoUrl + '/'+ uniqueId + '/'+ channelId,
		type : 'GET',
		async : false,
		success : function(data) {
			console.log(data);
			var obj = JSON.parse(data);
			// console.log(obj);
			callBack(obj);
			// if (obj[0] == "success") {
			// 	return obj;
			// } else {
			// 	return 'failure';
			// }
		},
		complete : function(){

		}
	});
}