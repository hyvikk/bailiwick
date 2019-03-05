<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionsTbl extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transactions', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->enum('flag', ['hosting', 'domain']);
			$table->integer('attach_id');
			$table->integer('client_id');
			$table->decimal('amount', 10, 2);
			$table->integer('hosting_id')->nullable();
			$table->integer('domain_id')->nullable();

			$table->integer('year')->length(5);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('transactions');
	}
}
