<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class guruController extends Controller
{
    private string $draftKey = 'guru_create_draft';

    public function index()
    {
        $guru = Guru::with(['user', 'kelas'])
            ->latest()
            ->get();

        return view('environments.guru.content', compact('guru'));
    }

    public function create(Request $request)
    {
        $step = (int) $request->query('step', 1);
        $step = in_array($step, [1, 2], true) ? $step : 1;

        $guru = new guru();
        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $draft = session($this->draftKey);

        if ($step === 2 && empty($draft)) {
            return redirect()->route('guru.tambah', ['step' => 1])
                ->with('error', 'Silakan isi Step 1 terlebih dahulu.');
        }

        return view('environments.guru-form.content', compact(
            'guru',
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

            return redirect()->route('guru.tambah', ['step' => 2])
                ->with('success', 'Step 1 tersimpan. Lanjutkan ke Step 2.');
        }

        $draft = session($this->draftKey);
        if (empty($draft)) {
            return redirect()->route('guru.tambah', ['step' => 1])
                ->with('error', 'Draft Step 1 tidak ditemukan.');
        }

        $validated = $request->validate([
            'kelas_id'       => ['required', 'exists:kelas,id'],
            'nip'            => ['required', 'string', 'max:50', 'unique:guru,nip'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'no_hp'          => 'nullable|string',
            'alamat'         => ['nullable', 'string'],
            'status'         => ['required', 'in:aktif,nonaktif'],
        ]);

        DB::transaction(function () use ($draft, $validated) {
            $user = User::create([
                'name'     => $draft['name'],
                'email'    => $draft['email'],
                'password' => Hash::make($draft['password']),
            ]);

            guru::create([
                'user_id'        => $user->id,
                'kelas_id'       => $validated['kelas_id'],
                'nip'            => $validated['nip'],
                'jenis_kelamin'  => $validated['jenis_kelamin'],
                'no_hp'          => $validated['no_hp'] ?? null,
                'alamat'         => $validated['alamat'] ?? null,
                'status'         => $validated['status'],
            ]);
        });

        session()->forget($this->draftKey);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Request $request, guru $guru)
    {
        $guru->load(['user', 'kelas']);

        $step = (int) $request->query('step', 1);
        $step = in_array($step, [1, 2], true) ? $step : 1;

        $kelas = Kelas::orderBy('tingkat')->orderBy('nama_kelas')->get();
        $draft = null;

        return view('environments.guru-form.content', compact(
            'guru',
            'kelas',
            'step',
            'draft'
        ));
    }

    public function update(Request $request, guru $guru)
    {
        $guru->load('user');

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email,' . $guru->user_id],

            'kelas_id'       => ['required', 'exists:kelas,id'],
            'nip'            => ['required', 'string', 'max:50', 'unique:guru,nip,' . $guru->id],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'no_hp'          => 'nullable|string',
            'alamat'         => ['nullable', 'string'],
            'status'         => ['required', 'in:aktif,nonaktif'],
        ]);

        DB::transaction(function () use ($validated, $guru) {
            $guru->user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            $guru->update([
                'kelas_id'      => $validated['kelas_id'],
                'nip'           => $validated['nip'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp'         => $validated['no_hp'] ?? null,
                'alamat'        => $validated['alamat'] ?? null,
                'status'        => $validated['status'],
            ]);
        });

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(guru $guru)
    {
        DB::transaction(function () use ($guru) {
            $user = $guru->user;
            $guru->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function cancelDraft()
    {
        session()->forget($this->draftKey);

        return redirect()->route('guru.index')
            ->with('success', 'Input guru dibatalkan.');
    }
}
