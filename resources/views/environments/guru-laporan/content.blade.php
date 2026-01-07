@extends('templates.mastertemplate')

@section('title', 'Laporan Guru per Kelas')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                Laporan Data Guru Berdasarkan Kelas
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
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

                            @forelse ($k->guru as $index => $g)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $g->nip }}</td>
                                    <td>{{ $g->user?->name }}</td>
                                    <td>
                                        {{ $g->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                    <td>
                                        @if ($g->status === 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Tidak ada guru di kelas ini
                                    </td>
                                </tr>
                            @endforelse

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Data laporan guru belum tersedia
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
    @include('environments.guru-laporan.js')
@endsection
