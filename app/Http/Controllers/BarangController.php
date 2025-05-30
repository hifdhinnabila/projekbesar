<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
    $query = Barang::with('kategori'); //ambil data barang sekaligus kategori

    //jika ada parameter search, filter berdasarkan nama barang
    if ($request->has('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    //paginate hasil query dibagi 4 per halaman
    $barangs = $query->paginate(4);
    return view('barang.index', compact('barangs')); //
    }

    public function create()
    {
        $kategoris = Kategori::all(); //ambil semua kategori untuk dropdown kategori
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        //validasi inputan form
        $request->validate([
            'nama' => 'required|unique:barangs,nama',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'kategori_id' => 'required',
            'harga' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('barang', 'public');
        }

        Barang::create($data);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        //cari barang berdasarkan id
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        //validasi inputan form 
        $request->validate([
            'nama' => 'required|unique:barangs,nama,' . $barang->id,
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'kategori_id' => 'required',
            'harga' => 'required|numeric|min:0',
    ]);

    $data = $request->all();

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        // Simpan gambar baru
        $data['gambar'] = $request->file('gambar')->store('barang', 'public');
    }

    $barang->update($data);

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
}

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    //mengatur pagination menggunakan bootstrap styling
    public function boot()
    {
        Paginator::useBootstrap(); 
    }
}
