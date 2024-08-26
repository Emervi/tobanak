<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_user'); // Kolom untuk foreign key
            $table->unsignedBigInteger('id_cabang')->nullable(); // Kolom untuk foreign key
            $table->double('total_harga');
            $table->double('uang_pembayaran');
            $table->double('kembalian');
            $table->text('alamat')->nullable();
            $table->string('metode_pembayaran');
            $table->unsignedBigInteger('id_ekspedisi');
            $table->enum('status', ['Diproses', 'Dikemas', 'Dikirim', 'Selesai', 'Dibatalkan']);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_ekspedisi')->references('id_ekspedisi')->on('ekspedisis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
