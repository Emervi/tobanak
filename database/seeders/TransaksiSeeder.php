<?php

namespace Database\Seeders;

use App\Models\BarangTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
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
        $startDate = Carbon::create(2024, 10, 1);
        $endDate = Carbon::create(2024, 10, 30);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            Transaksi::insert([
                'id_transaksi' => null,
                'tanggal' => $date->toDateString(),
                'id_user' => 2,
                'uang_pembayaran' => rand(100000, 500000),
                'total_harga' => rand(300000, 500000),
                'kembalian' => rand(10000, 50000),
                'id_cabang' => 2,
                'status' => 'Selesai',
                'metode_pembayaran' => 'COD',
                'id_ekspedisi' => rand(1, 5)
            ]);
        }

        // Transaksi::factory()
        // ->count(5)
        // ->create();

        // BarangTransaksi::create([
        //     'id_transaksi' => 1,
        //     'id_barang' => rand(1,7),
        //     'kuantitas' => rand(1, 10),
        //     'total_harga_barang' => rand(20000, 500000),
        // ]);

        // BarangTransaksi::create([
        //     'id_transaksi' => 2,
        //     'id_barang' => rand(1,7),
        //     'kuantitas' => rand(1, 10),
        //     'total_harga_barang' => rand(20000, 500000),
        // ]);

        // BarangTransaksi::create([
        //     'id_transaksi' => 3,
        //     'id_barang' => rand(1,7),
        //     'kuantitas' => rand(1, 10),
        //     'total_harga_barang' => rand(20000, 500000),
        // ]);

        // BarangTransaksi::create([
        //     'id_transaksi' => 4,
        //     'id_barang' => rand(1,7),
        //     'kuantitas' => rand(1, 10),
        //     'total_harga_barang' => rand(20000, 500000),
        // ]);

        // BarangTransaksi::create([
        //     'id_transaksi' => 5,
        //     'id_barang' => rand(1,7),
        //     'kuantitas' => rand(1, 10),
        //     'total_harga_barang' => rand(20000, 500000),
        // ]);
    }
}
