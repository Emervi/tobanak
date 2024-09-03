<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('id_rating');
            $table->unsignedBigInteger('id_user')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('id_transaksi')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('id_barang')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned(); // Misalnya rating dari 1-5
            $table->text('review')->nullable();
            $table->timestamps();

            $table->foreign('id_barang')->references('id_barang')->on('barangs')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
