<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Paymentreceipt extends Model {
	protected $table = "payment_receipt";
	protected $fillable = [
		'id', 'transaction_id', 'transaction_type', 'client_id', 'payment_type', 'amount',
	];

	// public function hosting() {
	// 	return $this->hasOne('App\Hostings', 'hosting_provider');

	// }
	public static function sum_amount($trans_id) {
		$sum = Paymentreceipt::groupBy('transaction_id')
			->where('transaction_id', $trans_id)
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}
	public static function total_payment($cid, $type) {
		$sum = Paymentreceipt::groupBy('client_id')
			->where('client_id', $cid)
			->where('transaction_type', $type)
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}

	public static function get_receipt_data($trans_id, $type) {
		$receipt = Paymentreceipt::where('transaction_id', '=', $trans_id)
			->where('transaction_type', $type)
			->get();
		return $receipt;
	}
	public static function get_report_receipt($client_id, $type) {
		$receipt = Paymentreceipt::where('client_id', '=', $client_id)
			->where('transaction_type', $type)
			->get();

		return $receipt;
	}

	public static function sum_domain_payment_current() {
		$sum = Paymentreceipt::groupBy('transaction_type')
			->where('transaction_type', 'domain')
			->whereMonth('created_at', '=', date('m'))
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}

	public static function sum_hosting_payment_current() {
		$sum = Paymentreceipt::groupBy('transaction_type')
			->where('transaction_type', 'hosting')
			->whereMonth('created_at', '=', date('m'))
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}
	public static function sum_domain_payment_last() {
		$sum = Paymentreceipt::groupBy('transaction_type')
			->where('transaction_type', 'domain')
			->whereMonth('created_at', '=', date("m-Y", strtotime("-1 months")))
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}
	public static function sum_hosting_payment_last() {
		$sum = Paymentreceipt::groupBy('transaction_type')
			->where('transaction_type', 'hosting')
			->whereMonth('created_at', '=', date("m-Y", strtotime("-1 months")))
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}
	public function client() {
		return $this->belongsTo('App\Clients');
	}
	public function transactions() {
		return $this->belongsTo('App\Transactions', 'transaction_id');
	}
}
