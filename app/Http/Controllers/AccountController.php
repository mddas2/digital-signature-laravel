<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payee;
use App\Fund;


class AccountController extends Controller
{
    private $_page = null;
    private $_data = [];

    public function __construct()
    {
        $this->_page = 'pages.accounts.';
    }

    public function add_payee(Request $request)
    {
        $payee = new Payee();
        $payee->name = $request->name;
        $payee->account_no = $request->account_no;
        $payee->remarks = $request->remarks;
        if ($payee->save()) {
            return redirect()->back()->with('success', 'Payee has been successfully added .');
        } else {
            return redirect()->back()->with('fail', 'Problem creating payee.');
        }

    }

    public function funds_transfer()
    {
        $payee = Payee::all();
        $this->_data['payee'] = $payee;
    	return view($this->_page.'funds_transfer',$this->_data);
    }

    public function funds_transfer_add(Request $request)
    {
        $funds = new Fund();
        $funds->payee_id = $request->payee;
        $funds->name = $request->name;
        $funds->account_no = $request->account_no;
        $funds->amount = $request->amount;
        $funds->remarks = $request->remarks;
        $funds->signature = $request->signature;
        if ($funds->save()) {
            return redirect()->back()->with('success', 'Funds has been successfully transferred .');
        } else {
            return redirect()->back()->with('danger', 'Funds could not be transferred successfully .');
        }
    }

    public function account_summary()
    {
    	$this->_data = [];
        $this->_data['funds_transfered'] = Fund::all();
        $this->_data['payee_list'] = Payee::all()->pluck('name','id')->toArray();
    	return view($this->_page.'account_summary',$this->_data);
    }

    public function getAccountDetails($id)
    {
        $this->_data = [];
        $this->_data['data'] = Fund::find($id);
        $this->_data['payee_list'] = Payee::all()->pluck('name','id')->toArray();
        return view($this->_page.'account_details',$this->_data);
    }
}