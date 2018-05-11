<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyTable extends Migration
{
 
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency');           
           
        });
    }


    public function down()
    {
        Schema::dropIfExists('currency'); 
    }
}
