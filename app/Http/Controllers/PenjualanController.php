<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->tgl_awal) && empty($request->tgl_akhir)) {
            $penjualans = Penjualan::with('pembeli', 'kasir', 'detailPenjualans')->paginate(5);
        } else {
            $penjualans = Penjualan::with('pembeli', 'kasir', 'detailPenjualans')
                ->whereBetween('tanggal_pesan', [$request->tgl_awal, $request->tgl_akhir])
                ->paginate(5);
        }

        return view('penjualan.index', compact('penjualans'));
    }


    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)->get();
        $pembelis = Pembeli::all();
        return view('penjualan.create', compact('barangs', 'pembelis'));
    }

    public function store(Request $request)
    {
        $request->validate([
             'pembeli_id' => 'required|exists:pembelis,id',
             'barang_idnya' => 'required|array',
             'barang_idnya.*' => 'required|exists:barangs,id',
             'jumlahdibeli' => 'required|array',
             'jumlahdibeli.*' => 'required|integer|min:1',
             'totaldibeli' => 'required|array',
             'totaldibeli.*' => 'required|numeric|min:0',
             'bayar' => 'required|numeric|min:0',
         ]);

        try {
            DB::beginTransaction();

            $penjualan = Penjualan::create([
                'pembeli_id' => $request->pembeli_id,
                'kasir_id' => session('idyangmasuk'),
                'tanggal_pesan' => date("Y-m-d"),
            ]);

            foreach ($request->barang_idnya as $index => $barang_id) {
                $barang = Barang::findOrFail($barang_id);
                $jumlah = $request->jumlahdibeli[$index];
                $total = $request->totaldibeli[$index];

                if ($barang->stok < $jumlah) {
                    throw new \Exception("Stok barang '{$barang->nama}' tidak mencukupi.");
                }

                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barang_id,
                    'jumlah' => $jumlah,
                    'total_harga' => $total,
                ]);

                $barang->stok -= $jumlah;
                $barang->save();
            }

            DB::commit();
            Session::flash('pesan', 'Data penjualan berhasil ditambahkan');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('penjualan.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('pembeli', 'kasir')->findOrFail($id);
        $detail = DetailPenjualan::where('penjualan_id', $penjualan->id)->with('barang')->get();
        return view('penjualan.detail', compact('penjualan', 'detail'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $penjualan = Penjualan::findOrFail($id);
            foreach ($penjualan->detailPenjualans as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok += $detail->jumlah;
                    $barang->save();
                }
                $detail->delete();
            }

            $penjualan->delete();

            DB::commit();
            Session::flash('pesan', 'Data penjualan berhasil dihapus');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('penjualan.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('penjualan.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function cetak(Request $request)
    {
        if (empty($request->tgl_awal) && empty($request->tgl_akhir)) {
            $penjualan = Penjualan::with('pembeli', 'kasir')->get();
        } else {
            $penjualan = Penjualan::with('pembeli', 'kasir')
                ->whereBetween('tanggal_pesan', [$request->tgl_awal, $request->tgl_akhir])
                ->get();
        }

        $pdf = Pdf::loadView('penjualan.cetakpenjualan', compact('penjualan'));
        $pdf->setOptions(['dpi' => 150]);

        return $pdf->stream('penjualan.pdf');
    }

    public function cetakdetail($id)
    {
        $penjualan = Penjualan::with('pembeli', 'kasir')->findOrFail($id);
        $detail = DetailPenjualan::where('penjualan_id', $id)->with('barang')->get();

        $pdf = Pdf::loadView('penjualan.cetakdetailpenjualan', compact('penjualan', 'detail'));
        $pdf->setOptions(['dpi' => 150]);

        return $pdf->stream('detailpenjualan.pdf');
    }
}
