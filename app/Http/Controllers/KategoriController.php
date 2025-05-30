<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query();

        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $kategori = $query->paginate(8);

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:kategoris,nama|string|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kategori.create')
                ->withErrors($validator)
                ->withInput();
        }

        Kategori::create([
            'nama' => $request->nama,
        ]);

        Session::flash('pesan', 'Kategori berhasil ditambahkan');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('kategori.index');
    }

    public function show(string $id)
    {
        // Tidak digunakan
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:3|unique:kategoris,nama,' . $kategori->id,
        ]);

        if ($validator->fails()) {
            return redirect()->route('kategori.edit', $kategori->id)
                ->withErrors($validator)
                ->withInput();
        }

        $kategori->update([
            'nama' => $request->nama,
        ]);

        Session::flash('pesan', 'Kategori berhasil diperbarui');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('kategori.index');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        Session::flash('pesan', 'Kategori berhasil dihapus');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('kategori.index');
    }
}
