<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaygetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paygets', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->string('channel_code');
            $table->string('channel_description');
            $table->string('payment_instructions_doc');
            $table->integer('transaction_fee_actual');
            $table->string('transaction_fee_type');
            $table->integer('transaction_fee_additional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paygets');
    }
}
