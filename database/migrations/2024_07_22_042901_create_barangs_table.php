<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('id_barang');
            $table->unsignedBigInteger('id_cabang');
            $table->string('nama_barang');
            $table->integer('stok_barang')->nullable();
            $table->text('deskripsi_barang')->nullable();
            $table->text('foto_barang')->nullable();
            $table->string('kategori_barang');
            $table->string('bahan');
            $table->double('harga');
            $table->integer('diskon');
            $table->integer('potongan');
            $table->enum('distribusi', ['Dikirim', 'Diterima', 'Ditolak']);
            $table->timestamps();

            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
