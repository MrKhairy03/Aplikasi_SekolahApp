<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function siswaPerKelas()
    {
        $kelas = Kelas::with(['siswa'])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('environments.siswa-laporan.content', compact('kelas'));
    }

    public function guruPerKelas()
    {
        $kelas = Kelas::with(['guru'])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('environments.guru-laporan.content', compact('kelas'));
    }

    public function kelasPerSiswaGuru()
    {
        $kelas = Kelas::with(['siswa.user', 'guru.user'])
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('environments.kelas-laporan.content', compact('kelas'));
    }
}
