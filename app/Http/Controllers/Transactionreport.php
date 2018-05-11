<?php
namespace App\Http\Controllers;
use App\Currency;
use App\Transactions;

class Transactionreport extends Controller {
	public function index() {
		$index['data'] = Transactions::get();
		$index['page'] = 'transaction_report';
		$index['amt_currency'] = Currency::select('currency')->first();

		return view("transactionreport", $index);
	}

}
