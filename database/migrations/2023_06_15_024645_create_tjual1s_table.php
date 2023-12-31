<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjual1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjual1s', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('tjual_id');
            $table->string('layanan_id');
            $table->string('name');
            $table->double('diskon', 20, 2)->default(0);
            $table->double('harga', 20, 2);
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
        Schema::dropIfExists('tjual1s');
    }
}
