<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    private string $draftKey = 'siswa_create_draft';

    public function index()
    {
        $siswa = Siswa::with(['user', 'kelas'])
            ->latest()
            ->get();

        return view('environments.siswa.content', compact('siswa'));
    }

    public function create(Request $request)
    {
        $step = (int) $request->query('step', 1);
        $step = in_array($step, [1, 2], true) ? $step : 1;

        $siswa = new Siswa();
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $draft = session($this->draftKey);

        if ($step === 2 && empty($draft)) {
            return redirect()->route('siswa.tambah', ['step' => 1])
                ->with('error', 'Silakan isi Step 1 terlebih dahulu.');
        }

        return view('environments.siswa-form.content', compact(
            'siswa',
            'kelas',
            'step',
            'draft'
        ));
    }

    public function store(Request $request)
    {
        $step = (int) $request->input('step', 1);

        if ($step === 1) {
            $validated = $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6'],
            ]);

            session([
                $this->draftKey => [
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => $validated['password'],
                ],
            ]);

            return redirect()->route('siswa.tambah', ['step' => 2])
                ->with('success', 'Step 1 tersimpan. Lanjutkan ke Step 2.');
        }

        $draft = session($this->draftKey);
        if (empty($draft)) {
            return redirect()->route('siswa.tambah', ['step' => 1])
                ->with('error', 'Draft Step 1 tidak ditemukan.');
        }

        $validated = $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'nis'            => ['required', 'string', 'max:50', 'unique:siswa,nis'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'tanggal_lahir'  => ['nullable', 'date'],
            'alamat'         => ['nullable', 'string'],
            'status'         => ['required', 'in:aktif,nonaktif'],
        ]);

        DB::transaction(function () use ($draft, $validated) {
            $user = User::create([
                'name'     => $draft['name'],
                'email'    => $draft['email'],
                'password' => Hash::make($draft['password']),
            ]);

            Siswa::create([
                'user_id'        => $user->id,
                'kelas_id'       => $validated['kelas_id'],
                'nis'            => $validated['nis'],
                'jenis_kelamin'  => $validated['jenis_kelamin'],
                'tanggal_lahir'  => $validated['tanggal_lahir'] ?? null,
                'alamat'         => $validated['alamat'] ?? null,
                'status'         => $validated['status'],
            ]);
        });

        session()->forget($this->draftKey);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Request $request, Siswa $siswa)
    {
        $siswa->load(['user', 'kelas']);

        $step = (int) $request->query('step', 1);
        $step = in_array($step, [1, 2], true) ? $step : 1;

        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $draft = null;

        return view('environments.siswa-form.content', compact(
            'siswa',
            'kelas',
            'step',
            'draft'
        ));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $siswa->load('user');

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email,' . $siswa->user_id],

            'kelas_id'       => ['required', 'exists:kelas,id'],
            'nis'            => ['required', 'string', 'max:50', 'unique:siswa,nis,' . $siswa->id],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'tanggal_lahir'  => ['nullable', 'date'],
            'alamat'         => ['nullable', 'string'],
            'status'         => ['required', 'in:aktif,nonaktif'],
        ]);

        DB::transaction(function () use ($validated, $siswa) {
            $siswa->user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            $siswa->update([
                'kelas_id'      => $validated['kelas_id'],
                'nis'           => $validated['nis'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'alamat'        => $validated['alamat'] ?? null,
                'status'        => $validated['status'],
            ]);
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            $user = $siswa->user;
            $siswa->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function cancelDraft()
    {
        session()->forget($this->draftKey);

        return redirect()->route('siswa.index')
            ->with('success', 'Input siswa dibatalkan.');
    }
}
