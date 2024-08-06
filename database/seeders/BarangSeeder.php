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
        // Barang::factory()->count(20)->create();

        function isiBarang($nama, $stok, $deskripsi, $foto, $kategori, $bahan, $harga, $diskon, $potongan){

            Barang::create([
                'nama_barang' => $nama,
                'stok_barang' => $stok,
                'deskripsi_barang' => $deskripsi,
                'foto_barang' => $foto,
                'kategori_barang' => $kategori,
                'bahan' => $bahan,
                'harga' => $harga,
                'diskon' => $diskon,
                'potongan' => $potongan, 
            ]);

        };

        isiBarang(
            'Baju Batman',
            5,
            'Baju dengan model kelelawar, cocok dipakai ke pesta kostum',
            'baju batman.jpeg',
            'Kaos',
            'Tebal',
            254000,
            10,
            0
        );

        isiBarang(
            'Topi Bebek',
            6,
            'Topi dengan model bebek',
            'topi bebek.jpeg',
            'Topi',
            'Sedang',
            230000,
            25,
            0
        );

        isiBarang(
            'Jaket Dino',
            3,
            'Jaket dengan model dinosaurus berwarna hijau',
            'jaket dino.jpeg',
            'Jaket',
            'Tebal',
            254000,
            0,
            4000
        );

        isiBarang(
            'Topi Hiu',
            15,
            'Topi dengan model hiu',
            'topi hiu.jpeg',
            'Topi',
            'Tipis',
            200000,
            0,
            0
        );

        isiBarang(
            'Rok Biru Cerah',
            15,
            'Rok dengan warna biru cerah',
            'rok biru.jpeg',
            'Rok',
            'Street',
            220000,
            0,
            20000
        );

        isiBarang(
            'Sweater Beruang',
            3,
            'Sweater dengan motif kepala beruang yang lucu',
            'sweater beruang.jpeg',
            'Sweater',
            'Sedang',
            235000,
            15,
            0
        );

        isiBarang(
            'Celana Pendek Biru',
            9,
            'Celana pendek berwarna biru yang cocok digunakan ketika berada di Pantai',
            'celana biru.jpeg',
            'Celana',
            'Tipis',
            225000,
            0,
            100000
        );

        // Barang::create([
        //     'nama_barang' => 'Baju Anak Laki-laki',
        //     'stok_barang' => 50,
        //     'deskripsi_barang' => 'Baju anak laki-laki dengan desain modern dan nyaman.',
        //     'foto_barang' => 'path/to/image1.jpg',
        //     'kategori_barang' => 'Baju',
        //     'bahan' => 'Katun',
        //     'harga' => 100000,
        //     'diskon' => 10,
        //     'potongan' => 10000,
        // ]);

        // Barang::create([
        //     'nama_barang' => 'Baju Anak Perempuan',
        //     'stok_barang' => 30,
        //     'deskripsi_barang' => 'Baju anak perempuan dengan desain cantik dan lucu.',
        //     'foto_barang' => 'path/to/image2.jpg',
        //     'kategori_barang' => 'Celana',
        //     'bahan' => 'Poliester',
        //     'harga' => 120000,
        //     'diskon' => 10,
        //     'potongan' => 10000,
        // ]);

        // Barang::create([
        //     'nama_barang' => 'Celana Anak',
        //     'stok_barang' => 20,
        //     'deskripsi_barang' => 'Celana anak yang nyaman untuk aktivitas sehari-hari.',
        //     'foto_barang' => 'path/to/image3.jpg',
        //     'kategori_barang' => 'Baju Panjang',
        //     'bahan' => 'Denim',
        //     'harga' => 90000,
        //     'diskon' => 10,
        //     'potongan' => 10000,
        // ]);

        // Barang::create([
        //     'nama_barang' => 'Celana Bapak',
        //     'stok_barang' => 20,
        //     'deskripsi_barang' => 'Celana anak yang nyaman untuk aktivitas sehari-hari.',
        //     'foto_barang' => 'path/to/image3.jpg',
        //     'kategori_barang' => 'Baju Panjang',
        //     'bahan' => 'Denim',
        //     'harga' => 90000,
        //     'diskon' => 10,
        //     'potongan' => 10000,
        // ]);
        
        // Barang::create([
        //     'nama_barang' => 'Celana Renang',
        //     'stok_barang' => 20,
        //     'deskripsi_barang' => 'Celana anak yang nyaman untuk aktivitas sehari-hari.',
        //     'foto_barang' => 'path/to/image3.jpg',
        //     'kategori_barang' => 'Baju Panjang',
        //     'bahan' => 'Denim',
        //     'harga' => 90000,
        //     'diskon' => 10,
        //     'potongan' => 10000,
        // ]);

        // Tambahkan lebih banyak data barang sesuai kebutuhan
    }
}
