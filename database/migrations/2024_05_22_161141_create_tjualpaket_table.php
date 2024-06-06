<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjualpaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjualpaket', function (Blueprint $table) {
            //
            $table->id();
            $table->foreignId('tjual_id');
            $table->string('nama_paket', 255);
            $table->tinyInteger('durasi');
            $table->double('harga');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->string('sisa_durasi')->nullable();
            $table->tinyInteger('status');
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
        Schema::table('tjualpaket', function (Blueprint $table) {
            //
        });
    }
}
