<?php
namespace App\Http\Controllers;
use App\Currency;
use App\Transactions;

class Transactionreport extends Controller {
	public function index() {
		$index['data'] = Transactions::get();
		$index['page'] = 'transaction_report';
		$index['amt_currency'] = Currency::select('currency')->first();
		/*$i=0;
		dd($index['data']);
		echo count($index['data']);
		foreach ($index['data'] as  $value) {
			echo ++$i."<br>";	
			//dd($value->hostings->domain_purchase_site);
		echo $value->hostings->domain_purchase_site."<br>";
		}
		dd("1");*/
		return view("transactionreport", $index);
	}

}
