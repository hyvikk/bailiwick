<?php
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	Route::get("/", 'HomeController@index');
	Route::resource('/clients', 'ClientsController');
	Route::resource('/domains', 'DomainsController');
	Route::resource('/hostings', 'HostingsController');
	Route::resource("/setting", 'SettingController');
	Route::resource("/report", 'ReportController');
	Route::resource("/transaction_report", 'Transactionreport');
	Route::resource("/payment_report", 'Paymentreport');
	Route::get("hosting_transaction", 'HostingsController@get_transactions');
	Route::get("domain_transaction", 'DomainsController@get_transactions');
	Route::get("hosting_payment_receipt", 'HostingsController@add_paymentreceipt');
	Route::get("domain_payment_receipt", 'DomainsController@add_paymentreceipt');
	Route::get("domain_renew", 'DomainsController@renew_domain');
	Route::get("domain_view_receipt", 'DomainsController@view_receipt');
	Route::get("domain_report_receipt", 'DomainsController@view_report_receipt');
	Route::get("hosting_view_receipt", 'HostingsController@view_receipt');
	Route::get("hosting_report_receipt", 'HostingsController@view_report_receipt');
	Route::get("hosting_renew", 'HostingsController@renew_hosting');
	Route::get('/changepass', 'PasswordController@index');
	Route::post('/changepassword', 'PasswordController@changepassword');
});