<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barang::create([
            'nama_barang' => 'Baju Anak Laki-laki',
            'stok_barang' => 50,
            'deskripsi_barang' => 'Baju anak laki-laki dengan desain modern dan nyaman.',
            'foto_barang' => 'path/to/image1.jpg',
            'kategori_barang' => 'Baju',
            'bahan' => 'Katun',
            'harga' => 100000,
            'diskon' => 10,
            'potongan' => 10000,
        ]);

        Barang::create([
            'nama_barang' => 'Baju Anak Perempuan',
            'stok_barang' => 30,
            'deskripsi_barang' => 'Baju anak perempuan dengan desain cantik dan lucu.',
            'foto_barang' => 'path/to/image2.jpg',
            'kategori_barang' => 'Celana',
            'bahan' => 'Poliester',
            'harga' => 120000,
            'diskon' => 10,
            'potongan' => 10000,
        ]);

        Barang::create([
            'nama_barang' => 'Celana Anak',
            'stok_barang' => 20,
            'deskripsi_barang' => 'Celana anak yang nyaman untuk aktivitas sehari-hari.',
            'foto_barang' => 'path/to/image3.jpg',
            'kategori_barang' => 'Baju Panjang',
            'bahan' => 'Denim',
            'harga' => 90000,
            'diskon' => 10,
            'potongan' => 10000,
        ]);

        // Tambahkan lebih banyak data barang sesuai kebutuhan
    }
}
