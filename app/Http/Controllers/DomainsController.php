<?php
namespace App\Http\Controllers;
use App\Clients;
use App\Currency;
use App\Domains;
use App\Paymentreceipt;
use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Validator;

class DomainsController extends Controller {
	public function index() {
		$index['data'] = Domains::get();
		$index['page'] = 'domains';
		$index['amt_currency'] = Currency::select('currency')->first();
		return view("domains.index", $index);
	}

	public function create() {
		$result['data'] = Clients::select('id', 'name')->get();
		$result['amt_currency'] = Currency::select('currency')->first();
		$result['page'] = 'domains';
		return view("domains.create", $result);
	}

	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'domain_name' => 'required|unique:domains',
			'registrar' => 'required',
			'client_name' => 'required',
			'creation_date' => 'required',
			'expiry_date' => 'required',
			'amount' => 'required',
		]);
		if ($validator->fails()) {
			return redirect('domains/create')
				->withErrors($validator)
				->withInput();
		}

		$creation_date = date('Y-m-d', strtotime($request->get("creation_date")));
		$expiry_date = date('Y-m-d', strtotime($request->get("expiry_date")));
		$date1 = strtotime($request->get("expiry_date"));
		$date2 = strtotime($request->get("creation_date"));
		$time_difference = $date1 - $date2;
		$seconds_per_year = 60 * 60 * 24 * 365;
		$years = round($time_difference / $seconds_per_year);
		$Domain = new Domains;
		$Domain->user_id = Auth::user()->id;
		$Domain->client_id = $request->get("client_name");
		$Domain->domain_name = $request->get("domain_name");
		$Domain->creation_date = $creation_date;
		$Domain->note = $request->get("note");
		$Domain->expiry_date = $expiry_date;
		$Domain->registrar = $request->get("registrar");
		$Domain->save();
		$domain_id = $Domain->id;
		$Transaction = new Transactions;
		$Transaction->flag = 'domain';
		$Transaction->attach_id = $domain_id;
		$Transaction->domain_id = $domain_id;
		$Transaction->client_id = $request->get("client_name");
		$Transaction->amount = $request->get("amount");
		$Transaction->year = $years;
		$Transaction->save();
		return Redirect::route("domains.index");
	}

	public function edit($id) {
		$index['data'] = Domains::whereId($id)->first();
		$index['trans'] = Transactions::where('attach_id', '=', $id)
			->where('flag', '=', 'domain')
			->first();
		$index['clients'] = Clients::select('id', 'name')->get();
		$index['amt_currency'] = Currency::select('currency')->first();
		$index['page'] = 'domains';
		return view("domains.edit", $index);
	}

	public function update(Request $request, $id) {
		$validator = Validator::make($request->all(), [
			'domain_name' => 'required',
			'registrar' => 'required',
			'client_name' => 'required',
			'creation_date' => 'required',

			'expiry_date' => 'required',
			'amount' => 'required',
		]);
		if ($validator->fails()) {
			return redirect('domains/' . $request->get("id") . '/edit')
				->withErrors($validator)
				->withInput();
		}
		$creation_date = date('Y-m-d', strtotime($request->get("creation_date")));
		$expiry_date = date('Y-m-d', strtotime($request->get("expiry_date")));
		$date1 = strtotime($request->get("expiry_date"));
		$date2 = strtotime($request->get("creation_date"));
		$time_difference = $date1 - $date2;
		$seconds_per_year = 60 * 60 * 24 * 365;
		$years = round($time_difference / $seconds_per_year);
		$Domain = Domains::whereid($request->get('id'))->first();
		$Domain->user_id = Auth::user()->id;
		$Domain->client_id = $request->get("client_name");
		$Domain->domain_name = $request->get("domain_name");
		$Domain->creation_date = $creation_date;
		$Domain->note = $request->get("note");
		$Domain->expiry_date = $expiry_date;
		$Domain->registrar = $request->get("registrar");
		$Domain->save();
		$Transaction = Transactions::where('attach_id', '=', $id)
			->where('flag', '=', 'domain')
			->first();
		$Transaction->flag = 'domain';
		$Transaction->attach_id = $request->get('id');
		$Transaction->client_id = $request->get("client_name");
		$Transaction->amount = $request->get("amount");
		$Transaction->year = $years;
		$Transaction->save();
		return Redirect::route("domains.index");
	}

	public function destroy(Request $request) {
		Domains::find($request->get('id'))->delete();
		Transactions::where('attach_id', '=', $request->get('id'))
			->where('flag', '=', 'domain')
			->delete();
		return redirect()->route('domains.index');
	}

	public function get_transactions(Request $request) {
		$index['trans'] = Transactions::where('attach_id', '=', $request->id)
			->where('flag', '=', 'domain')
			->get();
		$index['amt_currency'] = Currency::select('currency')->first();
		foreach ($index['trans'] as $row) {
			$index['payment_receipt'] = Transactions::find($row->id)->payment_receipt;
			$index['sum'] = Paymentreceipt::sum_amount($row->id);
			$index['dd'] = Domains::select('domain_name')->where('id', '=', $row->attach_id)->first();
			$index['payment_receipt'] = Transactions::find($row->id)->payment_receipt;
		}
		$index['client_name'] = Clients::select('name')
			->where('id', '=', $index['trans'][0]['client_id'])
			->first();
		return view("domains.transactions", $index);
	}

	public function add_paymentreceipt(Request $request) {
		$domain_amount = $request->domain_amount;
		$domain_payment_type = $request->domain_payment_type;
		$validator = Validator::make($request->all(), [
			'domain_amount' => 'required',
			'domain_payment_type' => 'required',
		]);
		if ($validator->fails()) {
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else {
			$paymentreceipt = new Paymentreceipt;
			$paymentreceipt->transaction_id = $request->trans_id;
			$paymentreceipt->client_id = $request->client_id;
			$paymentreceipt->transaction_type = 'domain';
			$paymentreceipt->payment_type = $request->domain_payment_type;
			$paymentreceipt->amount = $request->domain_amount;
			$paymentreceipt->save();
			return \Response::json(array('success' => true));
		}

	}

	public function view_receipt(Request $request) {
		$index['receipt'] = Paymentreceipt::get_receipt_data($request->id, 'domain');
		//$index['receipt'] = Paymentreceipt::get_report_receipt($request->id,'domain');
		$index['amt_currency'] = Currency::select('currency')->first();
		return view("domains.receipt", $index);
	}

	public function view_report_receipt(Request $request) {
		//$index['receipt'] = Paymentreceipt::get_receipt_data($request->id,'domain');
		$index['receipt'] = Paymentreceipt::get_report_receipt($request->id, 'domain');
		$index['amt_currency'] = Currency::select('currency')->first();
		return view("domains.receipt", $index);
	}

	public function renew_domain(Request $request) {
		$domain_id = $request->domain_id;
		$client_id = $request->client_id;
		$domain_renew_year = $request->domain_renew_year;
		$domain_renew_amount = $request->domain_renew_amount;
		$expiry_date = $request->expiry_date;
		$validator = Validator::make($request->all(), [
			'domain_renew_year' => 'required',
			'domain_renew_amount' => 'required',

		]);
		if ($validator->fails()) {
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else {
			$d = "+" . $domain_renew_year . "" . "year";
			$new_expiry_date = date('Y-m-d', strtotime($d, strtotime($expiry_date)));
			Domains::where('id', $domain_id)->update(array('expiry_date' => $new_expiry_date));
			$Transaction = new Transactions;
			$Transaction->flag = 'domain';
			$Transaction->attach_id = $domain_id;
			$Transaction->client_id = $client_id;
			$Transaction->amount = $domain_renew_amount;
			$Transaction->year = $domain_renew_year;
			$Transaction->save();
			return \Response::json(array('success' => true));
		}
	}
}
