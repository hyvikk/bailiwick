<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model {
	protected $table = "clients";
	// public function hostings() {
	// 	return $this->hasOne('App\Hostings', 'client_id');
	// }
}
