<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model {
	protected $table = "transactions";
	protected $fillable = [
		'id', 'flag', 'attach_id', 'client_id', 'amount',
	];

	public function payment_receipt() {
		return $this->hasOne("App\Paymentreceipt", "transaction_id", "id");
	}

	public static function total_payment($cid, $type) {
		$sum = Transactions::groupBy('client_id')
			->where('client_id', $cid)
			->where('flag', $type)
			->selectRaw('sum(amount) as sum')
			->pluck('sum');
		if (!empty($sum[0])) {
			return $sum[0];
		} else {
			return 0;
		}
	}
	public function hostings() {
		return $this->belongsTo('App\Hostings', 'hosting_id');
	}
	public function domains() {
		return $this->belongsTo('App\Domains', 'domain_id');
	}
	public function clients() {
		return $this->belongsTo('App\Clients', 'client_id');
	}

}
