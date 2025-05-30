<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search') || $request->has('nama_sup')) {
            $search = $request->search ?? $request->nama_sup;
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $suppliers = $query->paginate(5);
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3|unique:suppliers,nama',
            'alamat' => 'required|string|min:5',
            'kode_pos' => 'required|string|min:3|max:10',
        ]);

        Supplier::create([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'kode_pos' => $validated['kode_pos'],
        ]);

        return redirect()->route('supplier.index')->with([
            'success' => 'Satu Supplier berhasil ditambah!',
            'alert-class' => 'alert-success',
        ]);
    }

    public function show(string $id)
    {
        // Kosongkan jika tidak dipakai
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3|unique:suppliers,nama,' . $supplier->id,
            'alamat' => 'required|string|min:5',
            'kode_pos' => 'required|string|min:3|max:10',
        ]);

        $supplier->update([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'kode_pos' => $validated['kode_pos'],
        ]);

        return redirect()->route('supplier.index')->with([
            'success' => 'Supplier berhasil diperbarui!',
            'alert-class' => 'alert-success',
        ]);
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')->with([
            'success' => 'Supplier berhasil dihapus!',
            'alert-class' => 'alert-success',
        ]);
    }
}
