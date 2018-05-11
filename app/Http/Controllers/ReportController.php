<?php
namespace App\Http\Controllers;
use App\Clients;
use App\Currency;
use App\Domains;
use App\Hostings;
use App\Paymentreceipt;
use App\Transactions;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class ReportController extends Controller {
	public function index() {
		$index['clients'] = Clients::select('id', 'name')->get();
		$index['page'] = 'report';

		// $index['currency'] = '$';
		// if (!empty($amt_currency->currency)) {
		// 	$index['currency'] = $amt_currency->currency;
		// }

		return view("clients.reports", $index);
	}

	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'client' => 'required',
		]);
		$index['amt_currency'] = Currency::select('currency')->first();
		if ($validator->fails()) {
			return redirect('/report')
				->withErrors($validator)
				->withInput();
		}
		$index['clients'] = Clients::select('id', 'name')->get();
		$index['domains'] = Domains::where('client_id', '=', $request->get("client"))->get();
		$index['hostings'] = Hostings::where('client_id', '=', $request->get("client"))->get();
		$index['client_id'] = $request->get("client");

		foreach ($index['domains'] as $row) {

			$trans = Transactions::where('attach_id', '=', $row->id)
				->where('flag', '=', 'domain')
				->get();
			$index['sum_domain'] = Transactions::total_payment($row->client_id, 'domain');
			$index['payment_receipt'] = Paymentreceipt::where('client_id', '=', $row->client_id)
				->where('transaction_type', '=', 'domain')
				->get();
			if (count($index['payment_receipt']) > 0) {
				//$sum = Paymentreceipt::sum_amount($trans[0]->id);
				$index['sum'] = Paymentreceipt::total_payment($row->client_id, 'domain');
			}
		}
		foreach ($index['hostings'] as $row) {

			$trans = Transactions::where('attach_id', '=', $row->id)
				->where('flag', '=', 'hosting')
				->get();
			$index['sum_host'] = Transactions::total_payment($row->client_id, 'hosting');
			$index['payment_receipt'] = Paymentreceipt::where('client_id', '=', $row->client_id)
				->where('transaction_type', '=', 'hosting')
				->get();
			if (count($index['payment_receipt']) > 0) {
				$index['sum'] = Paymentreceipt::total_payment($row->client_id, 'hosting');
			}
		}

		$index['page'] = 'report';
		//$sum_domain = Paymentreceipt::total_payment($request->get("client"),'domain');
		// $sum_hosting = Paymentreceipt::total_payment($request->get("client"),'hosting');
		$sum_domain = Transactions::total_payment($request->get("client"), 'domain');
		$sum_hosting = Transactions::total_payment($request->get("client"), 'hosting');
		$index['chartjs'] = app()->chartjs
			->name('pieChartTest')
			->type('pie')
			->size(['width' => 400, 'height' => 200])
			->labels(['Domain', 'Hosting'])
			->datasets([
				[
					'backgroundColor' => ['#FF6384', '#36A2EB'],
					'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
					'data' => [$sum_domain, $sum_hosting],
				],
			])
			->options([]);
		return view("clients.reports", $index);
	}

}
