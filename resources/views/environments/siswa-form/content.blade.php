@extends('templates.mastertemplate')

@section('title', $siswa->exists ? 'Edit Siswa' : 'Tambah Siswa')

@section('contents')
    @php
        $isEdit = $siswa->exists;
    @endphp

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $isEdit ? 'Edit Siswa' : 'Tambah Siswa' }}
                </h6>
                @if (!$isEdit)
                    <small class="text-muted">Step {{ $step }} dari 2</small>
                @endif
            </div>

            <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">
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
                    <form method="POST" action="{{ route('siswa.store') }}" class="user">
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
                    <form method="POST" action="{{ route('siswa.store') }}" class="user">
                        @csrf
                        <input type="hidden" name="step" value="2">

                        <h6 class="font-weight-bold text-primary mb-3">Step 2 - Data Siswa</h6>

                        <div class="form-group">
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }} ({{ $k->tingkat }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input name="nis" class="form-control form-control-user" value="{{ old('nis') }}"
                                placeholder="NIS..." required>
                        </div>

                        <div class="form-group">
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>

                        <div class="form-group">
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat (optional)..."></textarea>
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
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-user">
                            Batalkan
                        </a>
                    </form>
                @endif
            @endif

            @if ($isEdit)
                <form method="POST" action="{{ route('siswa.update', $siswa->id) }}" class="user">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input name="name" class="form-control form-control-user"
                            value="{{ old('name', $siswa->user?->name) }}" required>
                    </div>

                    <div class="form-group">
                        <input name="email" class="form-control form-control-user"
                            value="{{ old('email', $siswa->user?->email) }}" required>
                    </div>

                    <div class="form-group">
                        <select name="kelas_id" class="form-control">
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }} ({{ $k->tingkat }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input name="nis" class="form-control form-control-user" value="{{ old('nis', $siswa->nis) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L" {{ $siswa->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $siswa->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ $siswa->tanggal_lahir }}">
                    </div>

                    <div class="form-group">
                        <textarea name="alamat" class="form-control" rows="3">{{ $siswa->alamat }}</textarea>
                    </div>

                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="aktif" {{ $siswa->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $siswa->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>

                    <button class="btn btn-success btn-user mr-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-user">
                        Batalkan
                    </a>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.siswa-form.js')
@endsection
