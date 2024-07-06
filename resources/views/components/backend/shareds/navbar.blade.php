<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('image/logo-pu-2.png') }}" alt="PUPR Logo" class="brand-image" />
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3 justify-content-end text-bold menu-center" id="navbarCollapse">
            <ul class="navbar-nav align-items-end pr-2">
                <li class="nav-item {{ Request::segment(2)=='dashboard'?'active':'' }}">
                    <a href="/" class="nav-link text-darkblue">Dashboard</a>
                </li>
                @can('lihat informasi utama')
                <!-- <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-darkblue">Anggaran</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{route('backend.dpa.index')}}" class="dropdown-item">DPA</a></li>
                        <li><a href="{{route('backend.rencana.program')}}" class="dropdown-item">Rencana Pengambilan</a></li>
                        <li><a href="{{route('backend.laporan')}}" class="dropdown-item">Laporan</a></li>
                    </ul>
                </li> -->
                @endcan
                @can('lihat kegiatan')
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-darkblue">Kegiatan</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{route('backend.kegiatan.index')}}" class="dropdown-item">Tambah</a></li>
                        <li><a class="dropdown-item" href="{{route('backend.kegiatan.laporan')}}">Laporan</a></li>
                        @can('lihat arsip')
                        <li><a href="{{route('backend.arsip.index')}}" class="dropdown-item ">Data Arsip</a></li>
                        @endcan
                        @can('lihat penyedia jasa')
                        <li><a href="{{route('backend.penyedia_jasa.index')}}" class="dropdown-item">Penyedia Jasa</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('lihat petunjuk')
                <li class="nav-item">
                    <a href="{{ route('backend.petunjuk.index') }}" class="nav-link text-darkblue">Petunjuk</a>
                </li>
                @endcan
                @can('lihat pengguna')
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-darkblue">Pengaturan</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        @can('lihat bidang')
                        <li><a href="{{route('backend.bidang.index')}}" class="dropdown-item">Pengaturan Bidang</a></li>
                        @endcan
                        @can('lihat program')
                        <li><a href="{{route('backend.program.index')}}" class="dropdown-item">Pengaturan Program</a></li>
                        @endcan
                        @can('lihat pengguna')
                        <li><a href="{{route('backend.users.index')}}" class="dropdown-item">Pengelolaan User</a></li>
                        @endcan
                        @can('lihat nomenklatur')
                        <li><a href="{{route('backend.nomenklatur.index')}}" class="dropdown-item">Pengaturan Nomenklatur</a></li>
                        @endcan
                        @can('lihat role')
                        <li><a href="{{route('backend.roles.index')}}" class="dropdown-item">Pengelolaan Role</a></li>
                        @endcan
                        @can('lihat permission')
                        <li><a href="{{route('backend.permissions.index')}}" class="dropdown-item">Pengelolaan Permission</a></li>
                        @endcan
                        @can('lihat sumber dana')
                        <li><a href="{{route('backend.sumber_dana.index')}}" class="dropdown-item">Pengaturan Sumber Dana</a></li>
                        @endcan
                        @can('lihat urusan')
                        <li><a href="{{route('backend.urusan.index')}}" class="dropdown-item">Pengaturan Urusan</a></li>
                        @endcan
                        @can('lihat organisasi')
                        <li><a href="{{route('backend.organisasi.index')}}" class="dropdown-item">Pengaturan Organisasi</a></li>
                        @endcan
                        @can('lihat unit')
                        <li><a href="{{route('backend.unit.index')}}" class="dropdown-item">Pengaturan Unit</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <div class="image px-0 pr-2 nav-link mb-1" data-toggle="dropdown">
                            <span class="ml-2">{{ auth()->user()->name }}</span>
                            <img src="{{ Storage::disk('local')->exists(auth()->user()->image) ? asset('uploads/' . auth()->user()->image) : asset('image/default-profile.png') }}" height="37px" width="40px" class="img-circle elevation-1" alt="User Image">
                        </div>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <a href="{{ route('backend.profile.index') }}" class="dropdown-item">
                                <i class="nav-icon fas fa-user text-black-50"></i> Profile
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                                <i class="nav-icon fas fa-sign-out-alt text-black-50"></i> Logout
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </ul>
        </div>
    </div>
</nav>
