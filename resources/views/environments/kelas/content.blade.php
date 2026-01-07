@extends('templates.mastertemplate')

@section('title', 'Data Kelas')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
            <a href="{{ route('kelas.tambah') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Kelas
            </a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Kode Kelas</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th style="width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelas as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $k->kode_kelas }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>
                                    <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <button type="button" class="btn btn-danger btn-sm js-delete-kelas" data-toggle="modal"
                                        data-target="#deleteKelasModal" data-action="{{ route('kelas.destroy', $k->id) }}"
                                        data-name="{{ $k->nama_kelas }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Data kelas belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteKelasModal" tabindex="-1" role="dialog" aria-labelledby="deleteKelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog mt-5" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteKelasModalLabel">Hapus Kelas?</h5>
                    <button class="close" type="button" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Anda yakin ingin menghapus kelas:
                    <div class="mt-2">
                        <b id="deleteKelasName">-</b>
                    </div>
                    <div class="alert alert-warning mt-3 mb-0">
                        Data kelas yang dihapus tidak dapat dikembalikan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Batal
                    </button>
                    <form id="deleteKelasForm" method="POST" class="m-0 p-0">
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
    @include('environments.kelas.js')
@endsection
