<?php

namespace Database\Seeders;

use App\Models\BarangTransaksi;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaksi::factory()
        ->count(5)
        ->create();

        BarangTransaksi::create([
            'id_transaksi' => 1,
            'id_barang' => rand(1,7),
            'kuantitas' => rand(1, 10),
            'total_harga_barang' => rand(20000, 500000),
        ]);

        BarangTransaksi::create([
            'id_transaksi' => 2,
            'id_barang' => rand(1,7),
            'kuantitas' => rand(1, 10),
            'total_harga_barang' => rand(20000, 500000),
        ]);

        BarangTransaksi::create([
            'id_transaksi' => 3,
            'id_barang' => rand(1,7),
            'kuantitas' => rand(1, 10),
            'total_harga_barang' => rand(20000, 500000),
        ]);

        BarangTransaksi::create([
            'id_transaksi' => 4,
            'id_barang' => rand(1,7),
            'kuantitas' => rand(1, 10),
            'total_harga_barang' => rand(20000, 500000),
        ]);

        BarangTransaksi::create([
            'id_transaksi' => 5,
            'id_barang' => rand(1,7),
            'kuantitas' => rand(1, 10),
            'total_harga_barang' => rand(20000, 500000),
        ]);
    }
}
