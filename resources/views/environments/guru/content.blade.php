@extends('templates.mastertemplate')

@section('title', 'Data Guru')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Guru</h6>
            <a href="{{ route('guru.tambah') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Guru
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
                            <th>NIP</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th style="width:120px;">Status</th>
                            <th style="width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($guru as $index => $g)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $g->user?->name ?? '-' }}</div>
                                    <div class="small text-muted">{{ $g->user?->email ?? '-' }}</div>
                                </td>
                                <td>{{ $g->nip }}</td>
                                <td>
                                    {{ $g->kelas?->nama_kelas }}
                                    <span class="text-muted">
                                        ({{ $g->kelas?->tingkat }})
                                    </span>
                                </td>
                                <td>
                                    {{ $g->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                                <td>{{ $g->no_hp ?? '-' }}</td>
                                <td>
                                    @if ($g->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('guru.edit', $g->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm js-delete-guru" data-toggle="modal"
                                        data-target="#deleteGuruModal" data-action="{{ route('guru.destroy', $g->id) }}"
                                        data-name="{{ $g->user?->name }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Data guru belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteGuruModal" tabindex="-1">
        <div class="modal-dialog mt-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Guru?</h5>
                    <button class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Anda yakin ingin menghapus guru:
                    <div class="mt-2">
                        <b id="deleteGuruName">-</b>
                    </div>
                    <div class="alert alert-warning mt-3 mb-0">
                        Data guru & user terkait akan ikut terhapus.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteGuruForm" method="POST">
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
    @include('environments.guru.js')
@endsection
