<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentReceiptTbl extends Migration {

	public function up() {
		Schema::create('payment_receipt', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('transaction_id');
			$table->string('transaction_type');
			$table->integer('client_id');
			$table->enum('payment_type', ['bank', 'cheque', 'cash', 'paypal']);
			$table->decimal('amount', 10, 2);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('payment_receipt');
	}
}
