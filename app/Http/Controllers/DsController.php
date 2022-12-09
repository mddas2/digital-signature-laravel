<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\User;
use App\mpin_transfer;
use Session;

class DsController extends Controller
{
	public function enrollSignature(Request $request)
	{
		$signature = $request->signature;
		$unique_id = $request->unique_id;

		$user = User::where(['unique_id' => $unique_id])->first();
		if ($user) {
			if($this->registerWithEmas($unique_id,$signature,false)) {
				User::where(['unique_id' => $unique_id])->update(['sign_data' => $signature,'is_enrolled' => 1]);
				$return['msg'] = "User has been successfully enrolled";
				$return['success'] = 1;
			} else {
				$return['msg'] = "User could not be enrolled";
				$return['success'] = 0;
			}
		} else {
			$return['msg'] = "unauthorized user";
			$return['success'] = 0;
		}
		return json_encode($return);
	}

	public function reEnrollSignature(Request $request)
	{
		$signature = $request->signature;
		$unique_id = $request->unique_id;

		$user = User::where(['unique_id' => $unique_id])->first();
		if ($user) {
			if ( $this->registerWithEmas($unique_id,$signature,true)) {
				User::where(['unique_id' => $unique_id])->update(['sign_data' => $signature]);
				$return['msg'] = "User has been successfully re-enrolled";
				$return['success'] = 1;
			} else {
				$return['msg'] = "User could not be re-enrolled";
				$return['success'] = 0;
			}
		} else {
			$return['msg'] = "unauthorized user";
			$return['success'] = 0;
		}
		return json_encode($return);
	}

	public function registerWithEmas($unique_id = null,$signature = null, $re_enroll = null)
	{
		if (!empty($unique_id) && !empty($signature)) {
			$result = $this->registerEmasUser($unique_id,$signature,$re_enroll);
			if ($result == true) {
				return true;
			} else {
				return false;
			} 
		} else {
			return false;
		}
	}

	public function registerEmasUser($unique_id = null,$signature = null,$re_enroll)
	{
		try {
			//$wsd = "http://103.69.124.130:8090/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			$wsd = "http://139.177.185.60:8082/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			//$wsd = "http://deepmind.radiantnepal.com:8080/emas3/services/authenticateWS?wsdl";
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = $unique_id.'~'.env('CHANNEL_ID');
          	$obj->arg1 = $signature;
          	$obj->arg2 = "9846537281";
          	$obj->arg3 = "kesh@gmail.com";
          	$obj->arg4 = false;
         
          	if ($re_enroll) {
          		$response = $client->reregister($obj);	
          	} else {
          		$response = $client->register($obj);
          	}
          //	dd($response);
         	if (strtok($response->return, '^') == "success") { 
          		return true;
          	} else {
          		return false;
          	}
		} catch (Exception $e) {
			$error = $e->getMessage();
			print_r($error);
			return false;
		}
	}

	public function checkUserExistsOrNot(Request $request)
	{
		$unique_id = $request->unique_id;
		try {
			//$wsd = "http://deepmind.radiantnepal.com:8080/emas3/services/authenticateWS?wsdl";
			$wsd = "http://139.177.185.60:8082/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = $unique_id.'~'.env('CHANNEL_ID');
	        $response = $client->userExists($obj);
	       	
        	return $response->return;
	    } catch (Exception $e) {
	        return null;
	    }
	}

	public function authentication(Request $request)
	{	
		$unique_id = $request->unique_id;
		$signature = $request->signature;
		try {
			//$wsd = "http://103.69.124.130:8090/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			$wsd = "http://139.177.185.60:8082/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			//$wsd = "http://deepmind.radiantnepal.com:8080/emas3/services/authenticateWS?wsdl";
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = $unique_id.'~'.env('CHANNEL_ID');
          	$obj->arg1 = $signature;
          	$obj->arg2 = null;
          	$obj->arg3 = "sdsdsds@gmail.com";
          	$response = $client->authenticate($obj);
          	
          	if (strpos($response->return,'-') !== false && strtok($response->return, '-') == "success") {
          		return "success";
          	} else {
          		return "error";
          	}
          	return $response->return;
          
		} catch (Exception $e) {
			$error = $e->getMessage();
			print_r($error);
			return false;
		}
	}

	public function formSigning(Request $request)
	{
		try {
			//$wsd = "http://103.69.124.130:8090/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			$wsd = "http://139.177.185.60:8082/emas3/services/dsverifyWS?wsdl";//AUTHENTICATION SERVER URL
			//$wsd = "http://deepmind.radiantnepal.com:8080/emas3/services/authenticateWS?wsdl";
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = 'pkcs7';
          	$obj->arg1 = $request->signature;
          	$obj->arg2 = 'xml';
          	$response = $client->verify($obj);
          	$data = simplexml_load_string($response->return);
          	$result = [];
          	if($data != '') {
          		$result['status'] = trim($data->status[0]);
          		$result['signedData'] = trim($data->transaction->signedData[0]);
          	} else {
          		return null;
          	}
          	return json_encode($result);
		} catch (Exception $e) {
			$error = $e->getMessage();
			print_r($error);
			return false;
		}
	}

	public function generateRandomNo($uniqueId, $channelId)
	{
		try {
			$wsd = "http://139.177.185.60:8082/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			//$wsd = "http://deepmind.radiantnepal.com:8080/emas3/services/authenticateWS?wsdl";
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = $uniqueId.'~'.$channelId;
           	$response = $client->generateRandomNumber($obj);
           	$result = explode("~",$response->return);
           	return json_encode($result);
		} catch (Exception $e) {
			$error = $e->getMessage();
			print_r($error);
			return false;
		}

	}

	public function restartEmSigner()
	{
		exec('C:\emSigner\emSigner\emSigner.exe');
		return redirect()->route('file_upload')->with('success','Emsigner Restarted');
	}

}
