<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNewModelPaketTjual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tjuals', function (Blueprint $table) {
            $table->tinyInteger('type_layanan')->nullable()->after('qty');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->string('durasi')->nullable();
            $table->string('sisa_durasi')->nullable();
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
