@extends('templates.mastertemplate')

@section('title', 'Laporan Siswa & Guru per Kelas')

@section('contents')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                Laporan Data Siswa & Guru Berdasarkan Kelas
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Nama</th>
                            <th>Peran</th>
                            <th>Identitas</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kelas as $k)
                            <tr class="bg-success text-white">
                                <td colspan="6">
                                    <strong>
                                        Kelas {{ $k->nama_kelas }} ({{ $k->tingkat }})
                                    </strong>
                                </td>
                            </tr>

                            @php
                                $no = 1;
                            @endphp
                            @forelse ($k->siswa as $s)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $s->user?->name }}</td>
                                    <td>
                                        <span class="badge badge-primary">Siswa</span>
                                    </td>
                                    <td>NIS: {{ $s->nis }}</td>
                                    <td>{{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $s->status === 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($s->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada siswa di kelas ini
                                    </td>
                                </tr>
                            @endforelse

                            @forelse ($k->guru as $g)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $g->user?->name }}</td>
                                    <td>
                                        <span class="badge badge-warning">Guru</span>
                                    </td>
                                    <td>NIP: {{ $g->nip }}</td>
                                    <td>{{ $g->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $g->status === 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($g->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada guru di kelas ini
                                    </td>
                                </tr>
                            @endforelse

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Data laporan kelas belum tersedia
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
    @include('environments.kelas-laporan.js')
@endsection
