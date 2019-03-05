<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DomainsTbl extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('domains', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id');
			$table->integer('client_id');
			$table->string('domain_name');
			$table->date('creation_date');
			$table->longText('note');
			$table->date('expiry_date');
			$table->string('registrar');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('domains');
	}
}
