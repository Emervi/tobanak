<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkspedisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekspedisis', function (Blueprint $table) {
            $table->id('id_ekspedisi');
            $table->string('nama_ekspedisi');
            $table->string('jenis_pengiriman');
            $table->double('harga_ekspedisi');
            $table->integer('estimasi_pengiriman');
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
        Schema::dropIfExists('ekspedisis');
    }
}
