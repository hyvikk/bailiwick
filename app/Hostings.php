<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Hostings extends Model {
	protected $table = "hostings";

	public function transaction() {
		return $this->hasOne('App\Transactions', 'hosting_id');
	}

	public function domain() {
		return $this->hasOne('App\Domains', 'id','domain_id');
	}

	public function clients() {
		return $this->belongsTo('App\Clients', 'client_id');
	}
}
