<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\User;
use App\mpin_transfer;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
	public function userLogin(Request $request)
	{
 		$username = $request->email;
     	$user = User::where(['email' => $username])->first();
     	if ($user) {
     		if (Hash::check($request->password,$user->password)) {
     			if($user->is_enrolled == "1") {
	                return $user;
	            } else {
	                return "inactive";
	            }
     		} else {
     			return "up_error";
     		}
     	} else {
     		return "up_error";
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


	public function enrollSignature(Request $request)
	{
		$signature = $request->signature;
		$serial = $request->serial_no;
		$email = $request->email;
		$random_no = $request->random_no;
		$reenroll = $request->re_enroll;

		$user = User::where(['email' => $email])->first();
		if ($user) {
			if (User::where(['email' => $email])->update(['sign_data' => $signature,'serial_number' => $serial])) {
				$registration = $this->registerWithEmas($email,$signature,$reenroll);
			} else {
				return 'cannot update the user data';
			}
		} else {
			return 'unauthorized user and email : '.$email;
		}
	}

	public function registerWithEmas($email =null,$signature = null,$reenroll = null)
	{
		if (!empty($email) || !empty($signature)) {
			$result = $this->registerEmasUser($email,$signature,$reenroll);
			if ($result == true) {
				print_r('level2');
				return true; 
			} else {
				return false;
			}
		} else {
			return 'empty email & signature';
		}
	}

	

	public function registerEmasUser($email = null,$signature = null,$reenroll = null)
	{
		$email = "hasta";
		try {
			//$wsd = "http://103.69.124.130:8090/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			$wsd = "http://139.177.185.60:8082/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			//$wsd = "http://deepmind.radiantnepal.com:8080/emas3/services/authenticateWS?wsdl";
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = $email.'~'.'rabin';
          	$obj->arg1 = $signature;
          	$obj->arg2 = "9846537281";
          	$obj->arg3 = "sdsdsds@gmail.com";
          	$obj->arg4 = false;

          	if ($reenroll == "true") {
          		$response = $client->reregister($obj);
          	} elseif ($reenroll == "false") {
  				$response = $client->register($obj);
          	} elseif ($reenroll == "2") {
          		$response = $client->authenticate($obj);
          	}
          	dd($response);
         	if ($response->return =='success') {
         		print_r("level1");
         		return true;
         	} else {
         		print_r('error');
         		return $response->return;
         	}
		} catch (Exception $e) {
			$error = $e->getMessage();
			print_r($error);
			return false;
		}
	}

	public function formSigning(Request $request) {
	    $signdata = $request->sign_data;
	    $serial_number = $request->serial_number;
	    $result = $this->verifyWithEmas($signdata);
    	if($result != null && $result['status'] == "success") {
      		$mt = new mpin_transfer;
	      	$mt->name = $request->name;
	     	$mt->email = $request->email;
	      	$mt->account_number = $request->account_number;
	      	$mt->mpin = $request->mpin;
	      	$mt->sign_data = $result['signedData'];
	      	$mt->serial_number = $result['serialNumber'];
	      	$save = $mt->save();
	      	if($save) {
	        	return "success";
	      	}else {
	      		return "error";
	      	}
    	}
    	return "errossr";
  	}

  	public function verifyWithEmas($signdata) {
  	//	dd($signdata);
    	$serialNumber = $email = $signedData = "";
    	try {
	        //$wsdl = "http://172.104.51.35:8082/emas2/services/dsverifyWS?wsdl";
	        $wsd = "http://139.177.185.60:8082/emas3/services/dsverifyWS?wsdl";
	        $client = new \SoapClient($wsd, array("trace" => TRUE));
	        $obj = new \stdClass();
	        $obj->arg0 = 'pkcs7';
	        $obj->arg1 = $signdata;
	        $obj->arg2 = 'xml';
	        $response = $client->verify($obj);
        	dd($response);
	        $data = simplexml_load_string($response->return);
	        $result = [];
	        if ($data != "") {
	            $result['status'] = $data->status;
	            $result['serialNumber'] = $data->transaction->transactionStatus->transactionStatusDetails->certificate->serialNumber;
	            $result['email'] = Session::get('email');
	            $result['signedData'] = $data->transaction->signedData;
	        } else {
	            return null;
	        }
        	return $result;
	    } catch (Exception $e) {
	        return null;
	    }
	}

	public function getMpinData()
	{
		$data = mpin_transfer::all();
		if ($data) {
			return view('mpin_list',compact('data'));
		} else {
			return rediect('/home');
		}
	}

	public function checkUserExistsOrNot(Request $request)
	{
		$request->unique_id = 'hasta';
		try {
			$wsd = "http://139.177.185.60:8082/emas3/services/authenticateWS?wsdl";
			//$wsd = "http://172.104.51.35:8082/emas3/services/authenticateWS?wsdl";//AUTHENTICATION SERVER URL
			$client = new \SoapClient($wsd, ['trace' => true]);
			$obj = new \StdClass();
			$obj->arg0 = $request->unique_id.'~'.'radiant';
	        $response = $client->userExists($obj);
        	return $response->return;
	    } catch (Exception $e) {
	        return null;
	    }
	}

	public function saveBase64(Request $request){
    try {
        $data = $request->input('data');
        $outFile = $request->input('outputfile');
        $base64data = substr($data, 0, stripos($data, 'Common name'));
        $base64data = preg_replace('/^[ \t]*[\r\n]+/m', '', $base64data);
        $base64data = str_replace('signature= ', '', $base64data);
        //$base64data = 'SGkgaSBhbSBzdXNoaWwga2hhdGkgY2hoZXRyaQ==';
        $pdf_decoded = base64_decode($base64data);
        //Write data back to pdf file
        $pdf = fopen($outFile, 'w');
        // return $pdf;
        // return array($base64data);
        fwrite($pdf, $pdf_decoded);
        //close output file
        fclose($pdf);
        return 'Done saving';
      } catch (Exception $e) {
          return 'Error catched saving base64 pdf';
      }
  }

}	
