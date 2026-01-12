<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            Sekolah_App
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Master Data
    </div>

    <li class="nav-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kelas.index') }}">
            <i class="fas fa-fw fa-chalkboard"></i>
            <span>Data Kelas</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('guru.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Data Guru</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('orangtua.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('orangtua.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Data Orangtua</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Laporan
    </div>

    <li class="nav-item {{ request()->routeIs('laporan.siswa') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.siswa') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Siswa per Kelas</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('laporan.guru') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.guru') }}">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Guru per Kelas</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('laporan.all') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.kelas') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Siswa & Guru</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
