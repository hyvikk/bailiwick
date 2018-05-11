<?php
namespace App\Http\Controllers;
use App\Currency;
use App\Domains;
use App\Hostings;
use App\Paymentreceipt;

class Paymentreport extends Controller {
	public function index() {
		$index['data'] = Paymentreceipt::get();
		$data = Paymentreceipt::get();
		$index['page'] = 'payment_report';

		$amt_currency = Currency::select('currency')->first();
		$currency = '$';
		if (!empty($amt_currency->currency)) {
			$currency = $amt_currency->currency;
		}

		foreach ($index['data'] as $row) {

			if ($row->transaction_type == 'domain') {
				$dname = Domains::where('client_id', '=', $row->client_id)
					->first(['domain_name']);
				$name = $dname->domain_name;

			} else if ($row->transaction_type == 'hosting') {
				$hname = Hostings::where('client_id', '=', $row->client_id)
					->first(['hosting_provider']);

				$name = $hname->hosting_provider;
			}
		}

		return view("paymentreport", $index, compact('name', 'currency'));
	}

}
