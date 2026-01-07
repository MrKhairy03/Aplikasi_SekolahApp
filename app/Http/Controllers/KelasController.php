<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('environments.kelas.content', compact('kelas'));
    }

    public function create()
    {
        $kelas = new Kelas();
        return view('environments.kelas-form.content', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string', 'max:50', 'unique:kelas,kode_kelas'],
            'nama_kelas' => ['required', 'string', 'max:255'],
            'tingkat'    => ['required', 'string', 'max:50'],
        ]);

        DB::transaction(function () use ($validated) {
            Kelas::create($validated);
        });

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        return view('environments.kelas-form.content', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string', 'max:50', 'unique:kelas,kode_kelas,' . $kelas->id],
            'nama_kelas' => ['required', 'string', 'max:255'],
            'tingkat'    => ['required', 'string', 'max:50'],
        ]);

        DB::transaction(function () use ($validated, $kelas) {
            $kelas->update($validated);
        });

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        DB::transaction(function () use ($kelas) {
            $kelas->delete();
        });

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}
