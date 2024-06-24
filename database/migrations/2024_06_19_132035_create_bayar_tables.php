<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBayarTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bayar', function (Blueprint $table) {
            //
            $table->id();
            $table->foreignId('patner_id');
            $table->string('noref',50)->nullable();
            $table->string('norek',100)->nullable();
            $table->string('atas_nama',100)->nullable();
            $table->string('bank',100)->nullable();
            $table->double('jumlah',24.2)->default(0);
            $table->string('bukti',)->nullable();
            $table->date('tgl');
            $table->text('ket')->nullable();
            $table->double('hutang_saat_bayar',24.2)->default(0);
            $table->bigInteger('input_by');
            $table->tinyInteger('status')->default(0);
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
        Schema::table('bayar', function (Blueprint $table) {
            //
        });
    }
}
