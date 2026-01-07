@extends('templates.mastertemplate')

@section('title', 'Data Siswa')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
            <a href="{{ route('siswa.tambah') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Siswa
            </a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Nama & Email</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th style="width:120px;">Status</th>
                            <th style="width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $s->user?->name }}</div>
                                    <div class="small text-muted">{{ $s->user?->email }}</div>
                                </td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->kelas?->nama_kelas }} ({{ $s->kelas?->tingkat }})</td>
                                <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>
                                    @if ($s->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm js-delete-siswa" data-toggle="modal"
                                        data-target="#deleteSiswaModal" data-action="{{ route('siswa.destroy', $s->id) }}"
                                        data-name="{{ $s->user?->name }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Data siswa belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteSiswaModal" tabindex="-1">
        <div class="modal-dialog mt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Siswa?</h5>
                    <button class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">
                    Anda yakin ingin menghapus siswa:
                    <div class="mt-2"><b id="deleteSiswaName">-</b></div>
                    <div class="alert alert-warning mt-3 mb-0">
                        Data siswa & user terkait akan ikut terhapus.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteSiswaForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.siswa.js')
@endsection
