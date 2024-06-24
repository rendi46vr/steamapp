<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patner', function (Blueprint $table) {
            //
            $table->id();
            $table->string('nama_patner');
            $table->string('nowa');
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::table('patner', function (Blueprint $table) {
            //
        });
    }
}
