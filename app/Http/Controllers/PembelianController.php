<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with(['barang', 'supplier']);

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $pembelians = $query->paginate(3);
        $suppliers = Supplier::all();

        return view('pembelian.index', compact('pembelians', 'suppliers'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('pembelian.create', compact('barangs', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            Pembelian::create($request->all());

            return redirect()->route('pembelian.index')->with('success', 'Pemasokan berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return redirect()->route('pembelian.index')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id); 
        $barangs = Barang::all();
        $suppliers = Supplier::all();

        return view('pembelian.edit', compact('pembelian', 'barangs', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        try {
            $pembelian = Pembelian::findOrFail($id);
            $pembelian->update($request->all());

            return redirect()->route('pembelian.index')->with('success', 'Pemasokan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->route('pembelian.index')->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pembelian = Pembelian::findOrFail($id);
            $pembelian->delete();

            return redirect()->route('pembelian.index')->with('success', 'Pemasokan berhasil dihapus!');
        } catch (\Throwable $e) {
            return redirect()->route('pembelian.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
