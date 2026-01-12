<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Orangtua;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrangtuaController extends Controller
{
    private string $draftKey = 'orangtua_create_draft';

    public function index()
    {
        $orangtua = Orangtua::with(['user', 'siswa'])
            ->latest()
            ->get();

        return view('environments.orangtua.content', compact('orangtua'));
    }

    public function create(Request $request)
    {
        $step = (int) $request->query('step', 1);
        $step = in_array($step, [1, 2], true) ? $step : 1;

        $orangtua = new orangtua();
        $siswa = Siswa::orderBy('kelas_id')->orderBy('nis')->get();
        $draft = session($this->draftKey);

        if ($step === 2 && empty($draft)) {
            return redirect()->route('orangtua.tambah', ['step' => 1])
                ->with('error', 'Silakan isi Step 1 terlebih dahulu.');
        }

        return view('environments.orangtua-form.content', compact(
            'orangtua',
            'siswa',
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

            return redirect()->route('orangtua.tambah', ['step' => 2])
                ->with('success', 'Step 1 tersimpan. Lanjutkan ke Step 2.');
        }

        $draft = session($this->draftKey);
        if (empty($draft)) {
            return redirect()->route('orangtua.tambah', ['step' => 1])
                ->with('error', 'Draft Step 1 tidak ditemukan.');
        }

        $validated = $request->validate([
            'siswa_id'       => ['required', 'exists:siswa,id'],
            'nik'            => ['required', 'string', 'max:50', 'unique:orang_tua,nik'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'alamat'         => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($draft, $validated) {
            $user = User::create([
                'name'     => $draft['name'],
                'email'    => $draft['email'],
                'password' => Hash::make($draft['password']),
            ]);

            orangtua::create([
                'user_id'        => $user->id,
                'siswa_id'       => $validated['siswa_id'],
                'nik'            => $validated['nik'],
                'jenis_kelamin'  => $validated['jenis_kelamin'],
                'alamat'         => $validated['alamat'] ?? null,
            ]);
        });

        session()->forget($this->draftKey);

        return redirect()->route('orangtua.index')
            ->with('success', 'Data orangtua berhasil ditambahkan.');
    }

    public function edit(Request $request, orangtua $orangtua)
    {
        $orangtua->load(['user', 'siswa']);

        $step = (int) $request->query('step', 1);
        $step = in_array($step, [1, 2], true) ? $step : 1;

        $siswa = Siswa::orderBy('kelas_id')->orderBy('nis')->get();
        $draft = null;

        return view('environments.orangtua-form.content', compact(
            'orangtua',
            'siswa',
            'step',
            'draft'
        ));
    }

    public function update(Request $request, orangtua $orangtua)
    {
        $orangtua->load('user');

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email,' . $orangtua->user_id],
            'siswa_id'       => ['required', 'exists:siswa,id'],
            'nik'            => ['required', 'string', 'max:50', 'unique:orang_tua,nik,' . $orangtua->id],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'alamat'         => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $orangtua) {
            $orangtua->user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            $orangtua->update([
                'siswa_id'      => $validated['siswa_id'],
                'nik'           => $validated['nik'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat'        => $validated['alamat'] ?? null,
            ]);
        });

        return redirect()->route('orangtua.index')
            ->with('success', 'Data orangtua berhasil diperbarui.');
    }

    public function destroy(orangtua $orangtua)
    {
        DB::transaction(function () use ($orangtua) {
            $user = $orangtua->user;
            $orangtua->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('orangtua.index')
            ->with('success', 'Data orangtua berhasil dihapus.');
    }

    public function cancelDraft()
    {
        session()->forget($this->draftKey);

        return redirect()->route('orangtua.index')
            ->with('success', 'Input orangtua dibatalkan.');
    }
}
