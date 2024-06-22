<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('image/logo.jpg') }}" alt="PUPR Logo" class="brand-image elevation-3" style="opacity: 0.8" />
            <span class="brand-text font-weight-light text-bold">PU-Net</span>
        </a>

        <!-- Left navbar links -->
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/" class="nav-link">Dashboard</a>
                </li>
                @can('lihat pengaturan')
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Kegiatan</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{route('backend.kegiatan.index')}}" class="dropdown-item">Tambah</a></li>
                        <li><a href="#" class="dropdown-item">Data Arsip</a></li>
                        <li><a href="{{route('backend.penyedia_jasa.index')}}" class="dropdown-item">Penyedia Jasa</a></li>
                    </ul>
                </li>
                @endcan

                @can('lihat pengaturan')
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Informasi</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{route('backend.informasi_utama.index')}}" class="dropdown-item">Informasi Utama</a></li>
                        <li><a href="{{route('backend.informasi_tagihan.index')}}" class="dropdown-item">Informasi Tagihan</a></li>
                    </ul>
                </li>
                @endcan

                @can('lihat pengaturan')
                <li class="nav-item">
                    <a href="#" class="nav-link">Petunjuk</a>
                </li>
                @endcan

                @can('lihat pengaturan')
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pengaturan</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="{{route('backend.bidang.index')}}" class="dropdown-item">Pengaturan Bidang</a></li>
                        <li><a href="{{route('backend.program.index')}}" class="dropdown-item">Pengaturan Program</a></li>
                        <li><a href="{{route('backend.users.index')}}" class="dropdown-item">Pengelolaan User</a></li>
                        <li><a href="{{route('backend.nomenklatur.index')}}" class="dropdown-item">Pengaturan Nomenklatur</a></li>
                    </ul>
                </li>
                @endcan

            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <div class="image nav-link mb-1" data-toggle="dropdown">
                    <img src="{{ asset('storage') . "/" . auth()->user()->image }}" height="37px" width="40px" class="img-circle elevation-2" alt="User Image">
                    <span class="ml-2">{{ auth()->user()->name }}</span>
                </div>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <a href="{{ route('backend.profile.index') }}" class="dropdown-item">
                        <i class="nav-icon fas fa-user text-black-50"></i> Profile
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();" class="dropdown-item">
                        <i class="nav-icon fas fa-sign-out-alt text-black-50"></i> Logout
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>