<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembeli::query();

        if ($request->has('search') || $request->has('nama_pembeli')) {
            $search = $request->search ?? $request->nama_pembeli;
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $pembelis = $query->paginate(5);

        return view('pembeli.index', compact('pembelis'));
    }

    public function create()
    {
        return view('pembeli.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|min:5',
            'no_hp' => 'required|numeric|unique:pembelis,no_hp',
        ]);

        Pembeli::create($validated);

        return redirect()
            ->route('pembeli.index')
            ->with([
                'success' => 'Satu pembeli berhasil ditambah!',
                'alert-class' => 'alert-success',
            ]);
    }

    public function edit(Pembeli $pembeli)
    {
        return view('pembeli.edit', compact('pembeli'));
    }

    public function update(Request $request, Pembeli $pembeli)
    {
        $validated = $request->validate([
            'nama' => 'required|string|min:3|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|min:5',
            'no_hp' => 'required|numeric|unique:pembelis,no_hp,' . $pembeli->id,
        ]);

        $pembeli->update($validated);

        return redirect()
            ->route('pembeli.index')
            ->with([
                'success' => 'Data pembeli berhasil diperbarui.',
                'alert-class' => 'alert-success',
            ]);
    }

    public function destroy(Pembeli $pembeli)
    {
        $pembeli->delete();

        return redirect()
            ->route('pembeli.index')
            ->with([
                'success' => 'Satu pembeli berhasil dihapus.',
                'alert-class' => 'alert-success',
            ]);
    }

    // Opsional, jika ingin show detail pembeli
    public function show(Pembeli $pembeli)
    {
        return view('pembeli.show', compact('pembeli'));
    }
}
