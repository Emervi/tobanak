<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangTransaksi;
use App\Models\Cabang;
use App\Models\Keranjang;
use App\Models\Rating;
use App\Models\Transaksi;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $id_user = session('customer')->id_user;
        $cabang_user = 1;
        $cabangs = Cabang::where('id_cabang', $cabang_user)->first();

        $totalJumlah = Keranjang::where('id_user', $id_user)
            ->sum('kuantitas');

        $filter = $request->query('filter');
        $kategori = Barang::where('distribusi', 'Diterima')
            ->distinct()
            ->pluck('kategori_barang');

        $query = Barang::where('distribusi', 'Diterima')
                ->orderByRaw("
                    CASE 
                        WHEN stok_barang >= 1 THEN 0
                        ELSE 1 
                    END
                ");

        if ($filter) {
            $query->where('kategori_barang', $filter);
        }

        // Load 'cabang' relationship
        $barangs = $query->with('cabang')->get();

        foreach ($barangs as $barang) {
            $bahan = $barang->bahan;
            switch ($bahan) {
                case 'Tebal':
                    $modal = 20000 * 10;
                    break;
                case 'Street':
                    $modal = 19000 * 10;
                    break;
                case 'Sedang':
                    $modal = 18000 * 10;
                    break;
                default:
                    $modal = 17000 * 10;
                    break;
            }

            $bebanProduksi = (2 / 100) * $modal;
            $keuntungan = (25 / 100) * $modal;
            $hargaJual = $modal + $bebanProduksi + $keuntungan;

            $barang->harga_asli = $hargaJual;
        }

        return view('customer.home', compact('barangs', 'kategori', 'totalJumlah', 'cabangs'));
    }


    public function keranjang()
    {
        return view('customer.keranjang');
    }

    public function show($id_barang)
    {
        $id_user = session('customer')->id_user;

        $barang = Barang::where('id_barang', $id_barang)->firstOrFail();

        $totalJumlah = Keranjang::where('id_user', $id_user)
            ->sum('kuantitas');

        $bahan = $barang->bahan;

        switch ($bahan) {
            case 'Tebal':
                $modal = 20000 * 10;
                break;
            case 'Street':
                $modal = 19000 * 10;
                break;
            case 'Sedang':
                $modal = 18000 * 10;
                break;
            default:
                $modal = 17000 * 10;
                break;
        }

        

        $rekomendasiBarang = Barang::where('kategori_barang', $barang->kategori_barang)
                            ->where('id_barang', '!=', $barang->id_barang)
                            ->where('stok_barang', '>=', 1)
                            ->limit(3)
                            ->get();

        $bebanProduksi = (2 / 100) * $modal;
        $keuntungan = (25 / 100) * $modal;
        $hargaJual = $modal + $bebanProduksi + $keuntungan;

        $barang->harga_asli = $hargaJual;

        return view('customer.detail', compact('barang', 'totalJumlah', 'rekomendasiBarang'));
    }

    // Penutup Halaman User

    // notifikasi pesanan berhasil
    public function notifikasiBerhasil()
    {
        $cabang_user = session('customer')->id_cabang;
        $cabangs = Cabang::where('id_cabang', $cabang_user)->first();

        return view('user.notifikasiPesananBerhasil', compact('cabangs'));
    }
    // \notifikasi pesanan berhasil





        public function pesananSaya(Request $request)
    {
        // Ambil id_customer dari session
        $id_customer = session('customer')->id_user;

        // Ambil parameter status dari request
        $status = $request->query('status');

        // Ambil transaksi berdasarkan status
        $transaksis = Transaksi::where('id_user', $id_customer)
            ->whereIn('status', ['diproses', 'dikirim', 'selesai'])
            ->latest()
            ->get();

        $transaksiId = $transaksis->pluck('id_transaksi')->toArray(); 

        // Ambil barang berdasarkan transaksiId dan filter status
        $barangs = BarangTransaksi::whereIn('barang_transaksis.id_transaksi', $transaksiId)
            ->join('barangs', 'barang_transaksis.id_barang', '=', 'barangs.id_barang')
            ->join('transaksis', 'barang_transaksis.id_transaksi', '=', 'transaksis.id_transaksi')
            ->join('ekspedisis', 'transaksis.id_ekspedisi', '=', 'ekspedisis.id_ekspedisi')
            ->join('cabangs', 'barangs.id_cabang', '=', 'cabangs.id_cabang')
            ->leftJoin('ratings', function ($join) use ($id_customer) {
                $join->on('barang_transaksis.id_barang', '=', 'ratings.id_barang')
                    ->on('barang_transaksis.id_transaksi', '=', 'ratings.id_transaksi')
                    ->where('ratings.id_user', $id_customer);
            })
            ->select('barang_transaksis.*', 'barangs.*', 'transaksis.total_harga', 
                    'transaksis.metode_pembayaran', 'ekspedisis.*', 'cabangs.*',
                    'barang_transaksis.created_at as barang_created_at',
                    'ratings.id_barang as rated_barang',
                    'ratings.id_transaksi as rated_transaksi',
                    'ratings.rating') 
            ->when($status, function ($query, $status) {
                return $query->where('barang_transaksis.status_barang', $status);
            })
            ->orderByRaw("
                CASE 
                    WHEN barang_transaksis.status_barang = 'dikirim' THEN 0
                    WHEN barang_transaksis.status_barang = 'diproses' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('transaksis.updated_at', 'desc')
            ->get();

        // Kirim data ke view
        return view('customer.pesanan-saya', compact('transaksis', 'barangs'));
    }




    public function konfirmasiPesanan(Request $request)
{
    $request->validate([
        'id_transaksi' => 'required',
        'id_barang' => 'required',
        'kuantitas' => 'required|numeric',
        'total_harga_barang' => 'required|numeric',
    ]);

    $transaksi = BarangTransaksi::where('id_transaksi', $request->id_transaksi)
    ->where('id_barang', $request->id_barang)
    ->update([
        'status_barang' => 'diterima',
        'kuantitas' => $request->kuantitas,
        'total_harga_barang' => $request->total_harga_barang,
    ]);

    if($transaksi) {
        $updated = BarangTransaksi::where('id_transaksi', $request->id_transaksi)
                    ->where('status_barang', 'Diproses')
                    ->exists();

        if(!$updated){
            Transaksi::where('id_transaksi', $request->id_transaksi)
                        ->update(['status' => 'Selesai']);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
}


public function batalPesanan(Request $request)
{
    $request->validate([
        'id_transaksi' => 'required',
        'id_barang' => 'required',
        'kuantitas' => 'required|numeric',
        'total_harga_barang' => 'required|numeric',
    ]);

    $transaksi = BarangTransaksi::where('id_transaksi', $request->id_transaksi)
    ->where('id_barang', $request->id_barang)
    ->update([
        'status_barang' => 'Dibatalkan',
        'kuantitas' => $request->kuantitas,
        'total_harga_barang' => $request->total_harga_barang,
    ]);

    $updated = BarangTransaksi::where('id_transaksi', $request->id_transaksi)
                ->where('status_barang', 'Diproses')
                ->exists();

    if(!$updated){
        Transaksi::where('id_transaksi', $request->id_transaksi)
                    ->update(['status' => 'Selesai']);
    }

    // $transaksi = BarangTransaksi::create([
    //     'id_transaksi' => $request->id_transaksi,
    //     'id_barang' => $request->id_barang,
    //     'status' => 'Dikirim',
    //     'kuantitas' => $request->kuantitas,
    //     'total_harga_barang' => $request->total_harga_barang,
    // ]);

    if($transaksi){
        $barang = Barang::where('id_barang', $request->id_barang)->first();
        if($barang){
            $barang->stok_barang += intval($request->kuantitas);
            $barang->save();
        }

        // dd($barang->stok_barang);

    }

    // dd($transaksi);


    return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
}





}


