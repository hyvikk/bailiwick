<?php
namespace App\Http\Controllers;
use App\Clients;
use App\Domains;
use App\Currency;
use App\Hostings;
use App\Paymentreceipt;
use App\Transactions;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class HostingsController extends Controller {
	public function index() {
		$index['data'] = Hostings::get();
		$index['page'] = 'hostings';
		$index['amt_currency'] = Currency::select('currency')->first();

		return view("hostings.index", $index);
	}

	public function create() {
		$index['data'] = Clients::select('id', 'name')->get();
		$index['amt_currency'] = Currency::select('currency')->first();
		$index['page'] = 'hostings';
		$index['domains'] = Domains::Select('id','domain_name','client_id')->get();
		return view("hostings.create", $index);
	}

	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'client_name' => 'required',
			'hosting_provider' => 'required',
			'start_date' => 'required',
			'end_date' => 'required |after:start_date',
			'hosting_type' => 'required',
			'notes' => 'required',
			'amount' => 'required',
			'purchase' => 'required',

		]);
		if ($validator->fails()) {
			return redirect('hostings/create')
				->withErrors($validator)
				->withInput();
		}
			$Hosting = new Hostings;
			$Hosting->client_id = $request->get("client_name");
			$Hosting->hosting_provider = $request->get("hosting_provider");
			if($request->get("domain_name"))
			{
				$Hosting->domain_id = $request->get("domain_name");
			}
			$Hosting->start_date = date('Y-m-d', strtotime($request->get("start_date")));
			$Hosting->end_date = date('Y-m-d', strtotime($request->get("end_date")));
			$Hosting->domain_purchase_site = $request->get("purchase");
			$date1 = strtotime($request->get("end_date"));
			$date2 = strtotime($request->get("start_date"));
			$time_difference = $date1 - $date2;
			$seconds_per_year = 60 * 60 * 24 * 365;
			$years = round($time_difference / $seconds_per_year);
			$Hosting->hosting_type = $request->get("hosting_type");
			$Hosting->notes = $request->get("notes");
			$Hosting->save();
			$host_id = $Hosting->id;
			$Transaction = new Transactions;
			$Transaction->flag = 'hosting';
			$Transaction->attach_id = $host_id;
			$Transaction->hosting_id = $host_id;
			$Transaction->client_id = $request->get("client_name");
			if($request->get("domain_name"))
			{
				$Transaction->domain_id = $request->get("domain_name");
			}
			$Transaction->amount = $request->get("amount");
			$Transaction->year = $years;
			$Transaction->save();
			return Redirect::route("hostings.index");		
		
	}

	public function edit($id) {
		$index['data'] = Hostings::whereId($id)->first();
		$index['trans'] = Transactions::where('attach_id', '=', $id)
			->where('flag', '=', 'hosting')
			->first();
		$index['clients'] = Clients::select('id', 'name')->get();
		$index['amt_currency'] = Currency::select('currency')->first();
		$index['page'] = 'hostings';
		$index['domains'] = Domains::select('id', 'domain_name')->get();
		return view("hostings.edit", $index);
	}

	public function update(Request $request, $id) {
		
		$validator = Validator::make($request->all(), [
			'client_name' => 'required',
			'hosting_provider' => 'required',
			'start_date' => 'required',
			'end_date' => 'required |after:start_date',
			'hosting_type' => 'required',
			'notes' => 'required',
			'amount' => 'required',

		]);
		if ($validator->fails()) {
			return redirect('hostings/' . $request->get("id") . '/edit')
				->withErrors($validator)
				->withInput();
		}
		$Hosting = Hostings::whereid($request->get('id'))->first();
		$Hosting->client_id = $request->get("client_name");
		$Hosting->hosting_provider = $request->get("hosting_provider");
		if($request->get("domain_name"))
		{
			$Hosting->domain_id = $request->get("domain_name");
		}
		$Hosting->start_date = date('Y-m-d', strtotime($request->get("start_date")));
		$Hosting->end_date = date('Y-m-d', strtotime($request->get("end_date")));
		$date1 = strtotime($request->get("end_date"));
		$date2 = strtotime($request->get("start_date"));
		$time_difference = $date1 - $date2;
		$seconds_per_year = 60 * 60 * 24 * 365;
		$years = round($time_difference / $seconds_per_year);
		$Hosting->hosting_type = $request->get("hosting_type");
		$Hosting->notes = $request->get("notes");
		$Hosting->save();
		$Transaction = Transactions::where('attach_id', '=', $id)
			->where('flag', '=', 'hosting')
			->first();
		$Transaction->flag = 'hosting';
		$Transaction->attach_id = $request->get('id');
		$Transaction->client_id = $request->get("client_name");
		if($request->get("domain_name"))
		{
			$Transaction->domain_id = $request->get("domain_name");
		}
		$Transaction->amount = $request->get("amount");
		$Transaction->year = $years;
		$Transaction->save();
		return Redirect::route("hostings.index");
	}

	public function destroy(Request $request) {
		Hostings::find($request->get('id'))->delete();
		Transactions::where('attach_id', '=', $request->get('id'))
			->where('flag', '=', 'hosting')
			->delete();
		return redirect()->route('hostings.index');

	}

	public function finddomain(Request $request)
	{
		$id = $request->client;
		$domain = Domains::where('client_id',$id)->select('id', 'domain_name')->get();
		return response()->json(json_encode($domain));
	}

	public function get_transactions(Request $request) {
		//dd($request);
		$index['trans'] = Transactions::where('attach_id', $request->id)
			->where('flag', '=', 'hosting')
			->get();
			//dd($index);
		$index['client_name'] = Clients::select('name')
			->where('id', '=', $index['trans'][0]['client_id'])
			->first();
			//dd($index);
		$index['amt_currency'] = Currency::select('currency')->first();
		$i=0;
		foreach ($index['trans'] as $row) {
			$index['payment_receipt'][$i] = Transactions::find($row->id)->payment_receipt;
			$index['sum'][$i] = Paymentreceipt::sum_amount($row->id);
			$index['dd'] = Hostings::select('hosting_provider')->where('id', '=', $row->attach_id)->first();	$i++;	
		}
		return view("hostings.transactions", $index);
	}
	public function add_paymentreceipt(Request $request) {
		$amount = $request->amount;
		$payment_type = $request->payment_type;
		$validator = Validator::make($request->all(), [
			'amount' => 'required',
			'payment_type' => 'required',
		]);
		if ($validator->fails()) {
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else {
			$paymentreceipt = new Paymentreceipt;
			$paymentreceipt->transaction_id = $request->trans_id;
			$paymentreceipt->client_id = $request->client_id;
			$paymentreceipt->transaction_type = 'hosting';
			$paymentreceipt->payment_type = $request->payment_type;
			$paymentreceipt->amount = $request->amount;
			$paymentreceipt->save();
			return \Response::json(array('success' => true));
		}

	}

	public function view_receipt(Request $request) {
		$index['receipt'] = Paymentreceipt::get_receipt_data($request->id, 'hosting');
		//$index['receipt'] = Paymentreceipt::get_report_receipt($request->id,'hosting');
		$index['amt_currency'] = Currency::select('currency')->first();
		return view("hostings.receipt", $index);
	}
	public function view_report_receipt(Request $request) {
		//$index['receipt'] = Paymentreceipt::get_receipt_data($request->id,'domain');
		$index['receipt'] = Paymentreceipt::get_report_receipt($request->id, 'hosting');
		$index['amt_currency'] = Currency::select('currency')->first();
		return view("hostings.receipt", $index);
	}
	public function renew_hosting(Request $request) {
		$hosting_id = $request->hosting_id;
		$client_id = $request->client_id;
		$domain_id = $request->domain_id;
		$hosting_renew_year = $request->hosting_renew_year;
		$hosting_renew_amount = $request->hosting_renew_amount;
		$end_date = $request->end_date;
		$validator = Validator::make($request->all(), [
			'hosting_renew_year' => 'required',
			'hosting_renew_amount' => 'required',

		]);
		if ($validator->fails()) {
			return \Response::json(array('errors' => $validator->errors()->toArray()));
		} else {
			$d = "+" . $hosting_renew_year . "" . "year";
			$new_end_date = date('Y-m-d', strtotime($d, strtotime($end_date)));
			Hostings::where('id', $hosting_id)->update(array('end_date' => $new_end_date));
			$Transaction = new Transactions;
			$Transaction->flag = 'hosting';
			$Transaction->attach_id = $hosting_id;
			$Transaction->client_id = $client_id;
			$Transaction->domain_id = $domain_id;
			$Transaction->hosting_id = $hosting_id;
			$Transaction->amount = $hosting_renew_amount;
			$Transaction->year = $hosting_renew_year;
			$Transaction->save();
			return \Response::json(array('success' => true));
		}
	}

}
