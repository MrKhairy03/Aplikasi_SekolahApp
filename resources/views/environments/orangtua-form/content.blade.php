@extends('templates.mastertemplate')

@section('title', $orangtua->exists ? 'Edit Orangtua' : 'Tambah Orangtua')

@section('contents')
    @php
        $isEdit = $orangtua->exists;
    @endphp

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $isEdit ? 'Edit Orangtua' : 'Tambah Orangtua' }}
                </h6>
                @if (!$isEdit)
                    <small class="text-muted">Step {{ $step }} dari 2</small>
                @endif
            </div>

            <a href="{{ route('orangtua.index') }}" class="btn btn-secondary btn-sm">
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
                    <form method="POST" action="{{ route('orangtua.store') }}" class="user">
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
                    <form method="POST" action="{{ route('orangtua.store') }}" class="user">
                        @csrf
                        <input type="hidden" name="step" value="2">

                        <h6 class="font-weight-bold text-primary mb-3">Step 2 - Data Orangtua</h6>

                        <div class="form-group">
                            <select name="siswa_id" class="form-control" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">
                                        {{ $s->user?->name }} ({{ $s->nis }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input name="nik" class="form-control form-control-user" value="{{ old('nik') }}"
                                placeholder="NIK..." required>
                        </div>

                        <div class="form-group">
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat (optional)...">{{ old('alamat') }}</textarea>
                        </div>

                        <button class="btn btn-success btn-user mr-2">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('orangtua.index') }}" class="btn btn-secondary btn-user">
                            Batalkan
                        </a>
                    </form>
                @endif
            @endif

            @if ($isEdit)
                <form method="POST" action="{{ route('orangtua.update', $orangtua->id) }}" class="user">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input name="name" class="form-control form-control-user"
                            value="{{ old('name', $orangtua->user?->name) }}" required>
                    </div>

                    <div class="form-group">
                        <input name="email" class="form-control form-control-user"
                            value="{{ old('email', $orangtua->user?->email) }}" required>
                    </div>

                    <div class="form-group">
                        <select name="siswa_id" class="form-control" required>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->id }}" {{ $orangtua->siswa_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->user?->name }} ({{ $s->nis }}) </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input name="nik" class="form-control form-control-user"
                            value="{{ old('nik', $orangtua->nik) }}" required>
                    </div>

                    <div class="form-group">
                        <select name="jenis_kelamin" class="form-control">
                            <option value="L" {{ $orangtua->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ $orangtua->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $orangtua->alamat) }}</textarea>
                    </div>

                    <button class="btn btn-success btn-user mr-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('orangtua.index') }}" class="btn btn-secondary btn-user">
                        Batalkan
                    </a>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.orangtua-form.js')
@endsection
