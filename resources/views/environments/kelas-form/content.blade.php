@extends('templates.mastertemplate')

@section('title', $kelas->exists ? 'Edit Kelas' : 'Tambah Kelas')

@section('contents')
    @php
        $isEdit = $kelas->exists;
    @endphp

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ $isEdit ? 'Edit Kelas' : 'Tambah Kelas' }}
            </h6>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary btn-sm">
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

            <form action="{{ $isEdit ? route('kelas.update', $kelas->id) : route('kelas.store') }}" method="POST"
                class="user">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <input type="text" name="kode_kelas" class="form-control form-control-user"
                        value="{{ old('kode_kelas', $kelas->kode_kelas) }}" placeholder="Kode Kelas (contoh: XIPA1)"
                        required>
                </div>

                <div class="form-group">
                    <input type="text" name="nama_kelas" class="form-control form-control-user"
                        value="{{ old('nama_kelas', $kelas->nama_kelas) }}" placeholder="Nama Kelas (contoh: X IPA 1)"
                        required>
                </div>

                <div class="form-group">
                    <input type="text" name="tingkat" class="form-control form-control-user"
                        value="{{ old('tingkat', $kelas->tingkat) }}" placeholder="Tingkat (contoh: X / XI / XII)" required>
                </div>

                <hr>

                <button type="submit" class="btn btn-success btn-user mr-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary btn-user">
                    Batalkan
                </a>
            </form>
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.kelas-form.js')
@endsection
