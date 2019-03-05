<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HostingsTbl extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('hostings', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('client_id');
			$table->string('hosting_provider');
			$table->date('start_date');
			$table->date('end_date');
			$table->string('hosting_type');
			$table->string('notes');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('hostings');
	}
}
