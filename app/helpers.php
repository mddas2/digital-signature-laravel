<?php

// collected form data

function getDataToBeSigned($data){
	return $data->name . 
		'||' . $data->account_number .
		'||' . $data->amount;
}

function test($param){
echo $param;
}

function verifyWithEmas($signdata)
{
    $serialNumber = $email = $signedData = "";
    try {
        $wsdl = env('EMAS_SERVER')."emas2/services/dsverifyWS?wsdl";
        $client = new \SoapClient($wsdl, array("trace" => TRUE));
        $obj = new \stdClass();
        $obj->arg0 = 'pkcs7';
        $obj->arg1 = $signdata;
        $obj->arg2 = 'xml';
        $response = $client->verify($obj);

        $data = simplexml_load_string($response->return);
        $result = [];
        if ($data != "") {
            $result['status'] = $data->status;
            $result['serialNumber'] = $data->transaction->transactionStatus->transactionStatusDetails->certificate->serialNumber;
            $result['email'] = Auth()->user()->email;
            $result['signedData'] = $data->transaction->signedData;
        } else {
            return null;
        }
        return $result;
    } catch (Exception $e) {
        return null;
    }

}

function verifyFormDataWithEmas($tbsData, $sigature)
{
    $serialNumber = $email = $signedData = "";
    try {
        $wsdl = "http://139.177.185.60:8082/emas3/services/dsverifyWS?wsdl";
        $client = new \SoapClient($wsdl, array("trace" => TRUE));
        $obj = new \stdClass();
        $obj->arg0 = 'pkcs7';
        $obj->arg1 = $tbsData;
        $obj->arg2 = $sigature;
        $obj->arg3 = 'xml';
       // dd($obj);
        $response = $client->verifyDetached($obj);
        $data = simplexml_load_string($response->return);
      
        $result = [];
        if ($data != "") {
            if((string)$data->status == 'success') {
                $result['status'] = 'success';
                $result['serialNumber'] = $data->transaction->transactionStatus->transactionStatusDetails->certificate->serialNumber;
                $result['email'] = Auth()->user()->email;
                $result['signedData'] = $data->transaction->signedData;
                $result['signer']['commonName'] = $data->transaction->transactionStatus->transactionStatusDetails->certificate->commonName;
                $result['signer']['email'] = $data->transaction->transactionStatus->transactionStatusDetails->certificate->email;
                return $result;
            } else if((string)$data->status == 'exception'){
                $result['status']='exception';
                $details=(string)$data->statusDetail;
                $result['signer']['commonName']= getStringBetween($details,'CN=',',');
                $result['signer']['email']=getStringBetween($details,'E=',',');
                return $result;
            }
        } else {
            return null;
        }
        return $result;
    } catch (Exception $e) {
        dd($e);
        return null;
    }
}


function registerEmasUser($tbsData, $sigature)
{
    $serialNumber = $email = $signedData = "";
    try {
        $wsdl = env('EMAS_SERVER')."emas2/services/authenticateWS?wsdl";
        $client = new \SoapClient($wsdl, array("trace" => TRUE));
        $obj = new \stdClass();
        $obj->arg0 = $tbsData;
        $obj->arg1 = $sigature;
        $obj->arg2 = "";
        $obj->arg3 = "";
        $obj->arg4 = "";
        $obj->arg5 = false;
        $response = $client->register($obj);

        print_r($response);
        die('done');

        if($response->return == 'success'){
            return true;
        }
        $error = $response->return;
        // print_r($error);
        // die('done');
        return $error;
        
        }catch(\Exception $e){
            $error = $e->getMessage();
            return false;
        }
}

 function checkUser($email){
        try{
            $link = env('EMAS_SERVER')."emas2/services/authenticateWS?wsdl";

            $client = new SoapClient($link,array("trace" => TRUE));
            $user_obj = new stdClass();
            $user_obj->arg0 = $email;
            $checkUserExists = $client->userExists($user_obj);
            if($checkUserExists->return == 'success'){
                return "success";
            } else if ($checkUserExists->return == 'pending'){
                return "pending";
            }
            $error = $checkUserExists->return;
            return $error;
        }catch(\Exception $e){
            $error = $e->getMessage();
            return $error;
        }
    }

    function authenticationUser($email,$sig){
                        //checking for user to exist on the server
                         $link = env('EMAS_SERVER')."emas2/services/authenticateWS?wsdl";
                        $client = new SoapClient($link,array("trace" => TRUE));
                        $auth_obj = new stdClass();
                        $auth_obj->arg0 = trim($email);
                        $auth_obj->arg1 = trim($sig);
                        $auth_obj->arg2 = null;
                        $auth_obj->arg3 = '';
                        $checkAuthentication = $client->authenticate($auth_obj);
                        
                        print_r($checkAuthentication);
                        die('done');
                        $authenticate = explode('-',$checkAuthentication->return);
                        if($authenticate[0] == 'success' ){
                                return 1;
                        }
                        return 0;

    }


function getStringBetween($str,$from,$to)
{
    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
    return substr($sub,0,strpos($sub,$to));
}
