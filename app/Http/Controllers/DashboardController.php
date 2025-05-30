<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pembelian;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString(); // tanggal hari ini (format YYYY-MM-DD)

        // Statistik total
        $jumlahBarang = Barang::count();
        $jumlahPenjualan = Penjualan::count();
        $totalPendapatan = DetailPenjualan::sum('total_harga');

        // Statistik harian
        $rupiahHariIni = DetailPenjualan::whereDate('created_at', $today)->sum('total_harga');
        $barangHariIni = DetailPenjualan::whereDate('created_at', $today)->sum('jumlah');
        $barangMasukHariIni = Pembelian::whereDate('tanggal', $today)->sum('jumlah');
        $jumlahTransaksiHariIni = Penjualan::whereDate('tanggal_pesan', $today)->count();

        // Barang dengan stok rendah
        $barangStokRendah = Barang::where('stok', '<=', 5)->get();

        return view('dashboard', compact(
            'jumlahBarang',
            'jumlahPenjualan',
            'totalPendapatan',
            'rupiahHariIni',
            'barangHariIni',
            'barangMasukHariIni',
            'jumlahTransaksiHariIni',
            'barangStokRendah'
        ));
    }
}
