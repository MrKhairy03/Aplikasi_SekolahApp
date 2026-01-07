@extends('templates.mastertemplate')

@section('title', 'Laporan Siswa per Kelas')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                Laporan Data Siswa Berdasarkan Kelas
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kelas as $k)
                            <tr class="bg-success text-white">
                                <td colspan="5">
                                    <strong>
                                        Kelas {{ $k->nama_kelas }} ({{ $k->tingkat }})
                                    </strong>
                                </td>
                            </tr>

                            @forelse ($k->siswa as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->user?->name }}</td>
                                    <td>
                                        {{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                    <td>
                                        @if ($s->status === 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Tidak ada siswa di kelas ini
                                    </td>
                                </tr>
                            @endforelse

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Data laporan siswa belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('jssection')
    @include('environments.siswa-laporan.js')
@endsection
