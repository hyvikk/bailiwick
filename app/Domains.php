<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Domains extends Model {
	protected $table = "domains";

	public function clients() {
		return $this->belongsTo('App\Clients', 'client_id');
	}

	public function transactions() {
		return $this->hasOne('App\Transactions', 'domain_id', 'id');
	}
}
