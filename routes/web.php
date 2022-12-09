<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',function(){
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('user/login', 'UserController@userLogin');
Route::post('ds/checkUserExistsOrNot','DsController@checkUserExistsOrNot');
Route::get('user/generateRandomNo/{uniqueId}/{channelId}','UserController@generateRandomNo');
Route::post('ds/authentication','DsController@authentication');

Route::group(['middleware' => ['auth']], function() {
	Route::view('enroll_dsc','pages.dsc.enroll')->name('enroll_dsc');
	Route::view('re_enroll_dsc','pages.dsc.re_enroll')->name('re_enroll_dsc');
	Route::view('add_payee','pages.accounts.add_payee')->name('add_payee');

	Route::get('/accounts/funds_transfer','AccountController@funds_transfer')->name('funds_transfer');
	Route::get('/accounts/summary','AccountController@account_summary')->name('account_summary');
	Route::get('/accounts/details/{id}','AccountController@getAccountDetails')->name('account_details');

	Route::post('ds/enroll_signature','DsController@enrollSignature');
	Route::post('ds/re_enroll_signature','DsController@reEnrollSignature');
	Route::post('ds/form_signing','DsController@formSigning');

	Route::get('/file_signing','UploadController@fileSignList')->name('file_sign_list');
	Route::post('temp/upload',['as' => 'temp.upload','uses'=>'UploadController@tempUpload']);
	Route::get('/file_upload','UploadController@fileUpload')->name('file_upload');
	Route::post('/file_upload','UploadController@fileUploadAction');
	

	Route::post('/accounts/add_payee_detail','AccountController@add_payee')->name('add_payee_detail');
	Route::post('/accounts/funds_transfer','AccountController@funds_transfer_add')->name('funds_transfer_add');

	Route::get('/restart/emSigner','DsController@restartEmSigner')->name('restart-emsigner');
});



