<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('SessionId');
            $table->unsignedBigInteger('TransactionId');
            $table->string('ReferenceId');
            $table->string('Via');
            $table->string('Channel');
            $table->string('PaymentNo');
            $table->longText('QrString')->nullable();
            $table->string('PaymentName');
            $table->decimal('SubTotal', 10, 2);
            $table->decimal('Fee', 10, 2)->default(0);
            $table->decimal('Total', 10, 2);
            $table->string('FeeDirection')->nullable();
            $table->timestamp('Expired');
            $table->string('QrImage')->nullable();
            $table->string('QrTemplate')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
