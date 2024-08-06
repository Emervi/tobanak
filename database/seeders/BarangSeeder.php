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

        function isiBarang($nama, $stok, $deskripsi, $foto, $kategori, $bahan, $diskon, $potongan, $distribusi){

            // Harga modal dengan patokan bahan
        $bahan = $bahan;
        if ($bahan == 'Tebal') {
            $modal = 20000 * 10;
        } else if ($bahan == 'Street') {
            $modal = 19000 * 10;
        } else if ($bahan == 'Sedang') {
            $modal = 18000 * 10;
        } else {
            $modal = 17000 * 10;
        }

        // Menemukan harga jual
        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $keuntungan + $bebanProduksi;

        session()->put('hargaAsli', $hargaJual);

        // Pengecekan apakah ada diskon yang diinputkan
        if ( empty($diskon)  ){
            $diskon = 0;
        }else{
            $diskon = $diskon;
        }

        // Pengecekan apakah ada potongan yang diinputkan
        if ( empty($potongan) ){
            $potongan = 0;
        }else{
            $potongan = $potongan;
        }
        
        // Perhitungan harga diskon
        $hargaDiskon = ($diskon / 100) * $hargaJual;
        $hargaJual -= $hargaDiskon;

        // Perhitungan harga potongan
        $hargaJual -= $potongan;

            Barang::create([
                'nama_barang' => $nama,
                'stok_barang' => $stok,
                'deskripsi_barang' => $deskripsi,
                'foto_barang' => $foto,
                'kategori_barang' => $kategori,
                'bahan' => $bahan,
                'harga' => $hargaJual,
                'diskon' => $diskon,
                'potongan' => $potongan,
                'id_cabang' => rand(1, 2),
                'distribusi'=> $distribusi,
            ]);

        };

        isiBarang(
            'Baju Batman',
            5,
            'Baju dengan model kelelawar, cocok dipakai ke pesta kostum',
            'baju batman.jpeg',
            'Kaos',
            'Tebal',
            0,
            0,
            'Diterima'
        );

        isiBarang(
            'Topi Bebek',
            6,
            'Topi dengan model bebek',
            'topi bebek.jpeg',
            'Topi',
            'Sedang',
            25,
            0,
            'Dikirim'
        );

        isiBarang(
            'Jaket Dino',
            3,
            'Jaket dengan model dinosaurus berwarna hijau',
            'jaket dino.jpeg',
            'Jaket',
            'Tebal',
            0,
            4000,
            'Diterima'
        );

        isiBarang(
            'Topi Hiu',
            15,
            'Topi dengan model hiu',
            'topi hiu.jpeg',
            'Topi',
            'Tipis',
            0,
            0,
            'Dikirim'
        );

        isiBarang(
            'Rok Biru Cerah',
            15,
            'Rok dengan warna biru cerah',
            'rok biru.jpeg',
            'Rok',
            'Street',
            0,
            20000,
            'Ditolak'
        );

        isiBarang(
            'Sweater Beruang',
            3,
            'Sweater dengan motif kepala beruang yang lucu',
            'sweater beruang.jpeg',
            'Sweater',
            'Sedang',
            15,
            0,
            'Dikirim'
        );

        isiBarang(
            'Celana Pendek Biru',
            9,
            'Celana pendek berwarna biru yang cocok digunakan ketika berada di Pantai',
            'celana biru.jpeg',
            'Celana',
            'Tipis',
            0,
            100000,
            'Ditolak'
        );

        isiBarang(
            'Kolor Bapa',
            1,
            'Terbaru , wangi nya masih terasa',
            'celana biru.jpeg',
            'Celana',
            'Tipis',
            99,
            0,
            'Diterima'
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
