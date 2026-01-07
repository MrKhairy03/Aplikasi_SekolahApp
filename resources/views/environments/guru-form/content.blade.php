@extends('templates.mastertemplate')

@section('title', $guru->exists ? 'Edit Guru' : 'Tambah Guru')

@section('contents')
    @php
        $isEdit = $guru->exists;
    @endphp

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $isEdit ? 'Edit Guru' : 'Tambah Guru' }}
                </h6>
                @if (!$isEdit)
                    <small class="text-muted">Step {{ $step }} dari 2</small>
                @endif
            </div>

            <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!$isEdit)
                @if ($step === 1)
                    <form method="POST" action="{{ route('guru.store') }}" class="user">
                        @csrf
                        <input type="hidden" name="step" value="1">

                        <h6 class="font-weight-bold text-primary mb-3">Step 1 - Data Akun</h6>

                        <div class="form-group">
                            <input name="name" class="form-control form-control-user" value="{{ old('name') }}"
                                placeholder="Nama Lengkap..." required>
                        </div>

                        <div class="form-group">
                            <input name="email" type="email" class="form-control form-control-user"
                                value="{{ old('email') }}" placeholder="Email..." required>
                        </div>

                        <div class="form-group">
                            <input name="password" type="password" class="form-control form-control-user"
                                placeholder="Password..." required>
                        </div>

                        <button class="btn btn-success btn-user">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                @endif

                @if ($step === 2)
                    <form method="POST" action="{{ route('guru.store') }}" class="user">
                        @csrf
                        <input type="hidden" name="step" value="2">

                        <h6 class="font-weight-bold text-primary mb-3">Step 2 - Data Guru</h6>

                        <div class="form-group">
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_kelas }} ({{ $k->tingkat }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input name="nip" class="form-control form-control-user" value="{{ old('nip') }}"
                                placeholder="NIP..." required>
                        </div>

                        <div class="form-group">
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input name="no_hp" class="form-control form-control-user" value="{{ old('no_hp') }}"
                                placeholder="No HP (optional)...">
                        </div>

                        <div class="form-group">
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat (optional)...">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <button class="btn btn-success btn-user mr-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-user">
                            Batalkan
                        </a>
                    </form>
                @endif
            @endif

            @if ($isEdit)
                <form method="POST" action="{{ route('guru.update', $guru->id) }}" class="user">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input name="name" class="form-control form-control-user"
                            value="{{ old('name', $guru->user?->name) }}" required>
                    </div>

                    <div class="form-group">
                        <input name="email" class="form-control form-control-user"
                            value="{{ old('email', $guru->user?->email) }}" required>
                    </div>

                    <div class="form-group">
                        <select name="kelas_id" class="form-control" required>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ $guru->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} ({{ $k->tingkat }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input name="nip" class="form-control form-control-user" value="{{ old('nip', $guru->nip) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L" {{ $guru->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $guru->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input name="no_hp" class="form-control form-control-user"
                            value="{{ old('no_hp', $guru->no_hp) }}" placeholder="No HP (optional)...">
                    </div>

                    <div class="form-group">
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $guru->alamat) }}</textarea>
                    </div>

                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="aktif" {{ $guru->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $guru->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>

                    <button class="btn btn-success btn-user mr-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-user">
                        Batalkan
                    </a>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.guru-form.js')
@endsection
