<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('ruangan/index', [
            'ruangan' => ruangan::all(),
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('ruangan/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:255',
        ]);

        ruangan::create($validated);

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan');
    }

    public function edit(ruangan $ruangan)
    {
        return Inertia::render('ruangan/edit', [
            'ruangan' => $ruangan,
        ]);
    }

    public function update(Request $request, ruangan $ruangan)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:255',
        ]);

        $ruangan->update($validated);

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui');
    }

    public function destroy(ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus');
    }

}
