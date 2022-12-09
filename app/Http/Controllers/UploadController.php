<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\User;
use App\mpin_transfer;
use App\Upload;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
	private $_page = null;
    private $_data = [];

    public function __construct()
    {
        $this->_page = 'pages.uploads.';
    }


	public function fileSignList()
	{
		$this->_data['uploads'] = Upload::all();
		return view($this->_page.'list',$this->_data);
	}

	public function fileUpload()
	{
		return view($this->_page.'add',$this->_data);
	}

	public function fileUploadAction(Request $request)
	{
        // dd($request->all());
		$doc_path = "signedfile/";
		$filename = str_random(10) . '_' . date('YmdHis') . '.pdf';
		$signature = $this->grabSignatureOnly($request->signature);
       // Storage::disk('public')->put($doc_path.$filename,base64_decode($signature));
        //Storage::disk('public')->put(public_path() .$request->tempdoc,base64_decode($signature));
		Storage::disk('public')->put($doc_path.$filename, base64_decode($signature));
		if (isset($request->tempdoc)) {
            File::delete(public_path() .$request->tempdoc);
        }

        $upload = new Upload();
        $upload->file_name = $filename;
        $upload->signature = $signature;
        if ($upload->save()) {
        	return redirect()->route('file_sign_list')->with('success', 'File has been successfully uploaded .');
        }
        return redirect()->back()->with('danger', 'File could not be uploaded .');
	}

	public function grabSignatureOnly($data)
	{
		$endChar = strpos($data, "CommonName");
		$base64data = substr($data, 0, stripos($data, 'Common name'));
        $base64data = preg_replace('/^[ \t]*[\r\n]+/m', '', $base64data);
        $base64data = str_replace('signature= ', '', $base64data);
        return trim(preg_replace('/\s+/', ' ', $base64data));
	}

	public function tempUpload(Request $request){
        $file = $request->file('file');
        if(null == $file){
            return response()->json(['status'=>'failed','msg'=>'No files found on request.','error-code'=>400],400);
        }
        $filename= str_random(10).'_'.date('YmdHis').'.'.$file->getClientOriginalExtension();
        $tempDir = '/tempUpload/';
        $result = $file->move(public_path().$tempDir,$filename);
        if($result){
            $upload = new Upload();
            $upload->non_signed_file = $filename;
            $upload->signature = '';
            $upload->save();
            return response()->json(['status'=>'success','filepath'=>$tempDir.$filename],200);

        }else {
            return response()->json(['status'=>'failed','msg'=>'Failed to save file.','error-code'=>500],500);

        }
    }
}