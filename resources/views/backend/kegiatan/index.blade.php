@extends('layouts.main')

@section('title', 'Pengaturan Bidang')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .leaflet-container {
        height: 300px;
        max-width: 100%;
        border-radius: 15px;
    }

    .table th,
    .table td {
        padding: 8px;
    }
</style>
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray fs-10">{{ __('Kegiatan') }}</span></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Tambah Kegiatan') }}</span></li>
    </ol>
</div>
@endsection

@section('main')
@if (session()->has('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    </div>
</div>
@endif
@if (session()->has('error'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-error alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('error') }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="card">
        <div class="card-body p-0 m-0">
            <div class="flex justify-content-between">
                <div class="container p-0 m-0">
                    <div class="row pr-4">
                        <div class="col-md-6">
                            <form action="" method="GET">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3 col-lg-6 mb-2 mb-md-0">
                                        <label for="filter">Filter Tahun</label>
                                    </div>
                                    <div class="col-sm-8 col-md-9 col-lg-6">
                                        <select name="tahun" id="tahun_kegiatan" class="form-control" onchange="this.form.submit()" required>
                                            <option value="" selected>-- Pilih Tahun --</option>
                                            @for ($i = 0; $i < 5; $i++) <option value="{{ date('Y') - $i }}">{{ ((int)date('Y')) - $i }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <a href="{{ route('backend.kegiatan.search') }}" class="btn btn-default btn-sm me-2">
                                <i class="fas fa-search"></i> Pencarian
                            </a>
                            <button type="button" class="btn btn-default btn-sm me-2" data-toggle="modal" data-target="#modal-lg-dana">
                                <i class="fa fa-money"></i> Sumber Dana
                            </button>
                            @can('tambah kegiatan')
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-lg-create">Manual</a>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-bidang-tab" data-toggle="pill" href="#custom-content-below-bidang" role="tab" aria-controls="custom-content-below-bidang" aria-selected="true">Bidang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-content-below-program-tab" data-toggle="pill" href="#custom-content-below-program" role="tab" aria-controls="custom-content-below-program" aria-selected="false">Program</a>
            </li>
        </ul>

        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade show active" id="custom-content-below-bidang" role="tabpanel" aria-labelledby="custom-content-below-bidang-tab">
                <div class="row">
                    <div class="col-12">
                        <div id="accordion">
                            @foreach ($bidang as $item)
                            <div class="card">
                                <div class="p-3">
                                    <div id="heading-{{$item->id}}" onclick="getKegiatan({{$item->id}})" class="p-2 mb-2" data-toggle="collapse" data-target="#collapse-{{$item->id}}" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="card-table">
                                            <p class="taf text-darkblue">
                                                <strong>{{$item->name}}</strong>
                                            </p>
                                            <div class="card-table-cell tar">
                                                <button type="button" class=" btn btn-sm btn-secondary rounded" style="width: 120pt"><strong>Total Kegiatan : {{$item->kegiatan->count()}}</strong></button>
                                                <button type="button" class="btn btn-sm btn-secondary rounded" style="width: 200pt"><strong>Total Pagu : Rp {{number_format($item->kegiatan->sum('alokasi'))}}</strong></button>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-responsive table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="2">Kode</th>
                                                <th class="text-center" rowspan="2">Judul</th>
                                                <th class="text-center" rowspan="2">Output</th>
                                                <th class="text-center" colspan="2">Alokasi</th>
                                                <th class="text-center" rowspan="2">Verifikasi Admin</th>
                                                <th class="text-center" rowspan="2">Komentar</th>
                                                <th class="text-center" rowspan="2">Verifikasi Pengawas</th>
                                                <th class="text-center" rowspan="2">Komentar</th>
                                                <th class="text-center" rowspan="2">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Kegiatan</th>
                                                <th class="text-center">Sub Kegiatan</th>
                                                <th class="text-center">Pagu / Nilai Kontrak</th>
                                                <th class="text-center">Realisasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->kegiatan as $kegiatan)
                                            @if ($kegiatan->is_arship == 0)
                                            <tr class="table-success">
                                                <td>{{$kegiatan->no_rek}}</td>
                                                <td></td>
                                                <td class="text-center ">{{$kegiatan->title}}</td>
                                                <td class="text-center">Fisik</td>
                                                <td class="text-center">Rp.{{number_format($kegiatan->alokasi)}}</td>
                                                <td class="text-center">Rp.{{number_format($kegiatan->total_realisasi)}}</td>
                                                <td class="text-center" colspan="4"></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="btn-action">
                                                            @can('tambah detail kegiatan')
                                                            <button type="button" style="color: white;" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-tambah-detail-{{$kegiatan->id}}"><i class="fas fa-plus"></i></button>
                                                            @endcan
                                                            @can('ubah detail kegiatan')
                                                            <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$kegiatan->id}}"><i class="fas fa-edit"></i></button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('backend.kegiatan._modal_update_pptk')
                                            @include('backend.kegiatan._modal_add_detail')

                                            @foreach ($kegiatan->detail_kegiatan as $detail)
                                            <tr>
                                                <td></td>
                                                <td>{{$detail->no_detail_kegiatan}}</td>
                                                <td class="text-center ">{{$detail->title}}</td>
                                                <td class="text-center">Fisik</td>
                                                <td class="text-center">Rp.{{number_format($detail->nilai_kontrak)}}</td>
                                                <td class="text-center">Rp.{{number_format($detail->realisasi)}}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('backend.detail_kegiatan.verifikasi', $detail->id) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="form-check">
                                                            @can('verifikasi admin')
                                                            <input type="hidden" name="verifikasi_admin" value="false">
                                                            <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="blankCheckbox" name="verifikasi_admin" value="{{ $detail->verifikasi_admin == 'true' ? 'false' : 'true' }}" {{ $detail->verifikasi_admin == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
                                                            @else
                                                            <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="blankCheckbox" {{ $detail->verifikasi_admin == 'true' ? 'checked' : '' }} disabled>
                                                            @endcan
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-floating" data-toggle="modal" data-target="#modal-lg-komentar-admin-{{$detail->id}}">
                                                        @can('komentar admin')
                                                        <textarea class="form-control" placeholder="Komentar" id="komentarAdmin" name="komentar_admin">{{ $detail->komentar_admin}}</textarea>
                                                        @else
                                                        <textarea class="form-control" placeholder="Komentar" disabled>{{ $detail->komentar_admin}}</textarea>
                                                        @endcan
                                                    </div>
                                                    @include('backend.kegiatan._modal_komentar', ['param'=>'admin'])
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <form action="{{ route('backend.detail_kegiatan.verifikasi', $detail->id) }}" method="POST">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="form-check">
                                                                @can('verifikasi pengawas')
                                                                <input type="hidden" name="verifikasi_pengawas" value="false"> <!-- Memastikan ketika unchecked checkbox nilainya tetap di kirim -->
                                                                <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="verifikasiPengawas" name="verifikasi_pengawas" value="{{ $detail->verifikasi_pengawas == 'true' ? 'false' : 'true' }}" {{ $detail->verifikasi_pengawas == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
                                                                @else
                                                                <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="blankCheckbox" {{ $detail->verifikasi_pengawas == 'true' ? 'checked' : '' }} disabled>
                                                                @endcan
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                                <!-- Komentar -->
                                                <td class="text-center">
                                                    <div class="form-floating" data-toggle="modal" data-target="#modal-lg-komentar-pengawas-{{$detail->id}}">
                                                        @can('komentar pengawas')
                                                        <textarea class="form-control" placeholder="Komentar" id="komentarPengawas" name="komentar_pengawas">{{ $detail->komentar_pengawas}}</textarea>
                                                        @else
                                                        <textarea class="form-control" placeholder="Komentar" disabled>{{ $detail->komentar_pengawas}}</textarea>
                                                        @endcan
                                                    </div>
                                                    @include('backend.kegiatan._modal_komentar', ['param'=>'pengawas'])
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        @can('lihat detail kegiatan')
                                                        <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail->id]) }}" class=" btn btn-sm btn-secondary "><i class="fas fa-eye"></i></a>
                                                        @endcan
                                                        @can('hapus detail kegiatan')
                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-lg-detail-delete-{{$detail->id}}"><i class="fas fa-trash"></i></button>
                                                        @endcan
                                                        @can('ubah detail kegiatan')
                                                        <button type="button" style="color: white;" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-lg-edit-detail-{{$detail->id}}"><i class="fas fa-edit"></i></button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('backend.kegiatan._modal_delete_detail')
                                            @include('backend.kegiatan._modal_edit_detail')
                                            @endforeach
                                            @include('backend.kegiatan._modal_edit_kegiatan')
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="custom-content-below-program" role="tabpanel" aria-labelledby="custom-content-below-program-tab">
                <div class="row">
                    <div class="col-12">
                        <div id="accordion-program">
                            @foreach ($program as $item)
                            <div class="card">
                                <div id="heading-program-{{$item->id}}" class="card-header btn btn-link" data-toggle="collapse" data-target="#collapse-program-{{$item->id}}" aria-expanded="true" aria-controls="collapseOne" style="background-color: #f5faff; border-radius: 0.5rem;">
                                    <div class="card-table">
                                        <p class="taf text-darkblue">
                                            <strong>{{$item->name}}</strong>
                                        </p>
                                        <div class="card-table-cell tar responsive">
                                            <button type="button" class=" btn btn-sm btn-secondary rounded"><strong>Total Kegiatan : {{$item->kegiatan->count()}}</strong></button>
                                            <button type="button" class="btn btn-sm btn-secondary rounded"><strong>Total Pagu : Rp {{number_format($item->kegiatan->sum('alokasi'))}}</strong></button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapse-program-{{$item->id}}" class="collapse" aria-labelledby="heading-program-{{$item->id}}" data-parent="#accordion-program">
                                    <div class="card-body table-responsive p-0" style="height: 500px;">
                                        <table class="table  text-nowrap">
                                            <tbody>
                                                @foreach ($item->kegiatan as $kegiatan)
                                                @if ($kegiatan->is_arship == 0)
                                                <tr class="table-detail-program">
                                                    <td>
                                                        <dl>
                                                            <dd>
                                                                <span class="text-darkblue">{{$kegiatan->title}}</span>
                                                            </dd>
                                                            <dd style="margin-bottom: 20px;margin-top: 10px;">
                                                                <span class="text-darkblue"><strong>No Rekening : </strong> {{$kegiatan->no_rek}}</span>
                                                            </dd>
                                                        </dl>
                                                    </td>
                                                    <td>
                                                        <dl>
                                                            <dt>
                                                                <label class="text-darkblue">Total Pagu</label>
                                                            </dt>
                                                            <dd>
                                                                <span class="text-darkblue">Rp {{number_format($kegiatan->alokasi)}}</span>
                                                            </dd>
                                                        </dl>
                                                    </td>
                                                    <td>
                                                        <dl>
                                                            <dt>
                                                                <label class="text-darkblue">Realisasi</label>
                                                            </dt>
                                                            <dd>
                                                                <span class="text-darkblue">Rp {{number_format($kegiatan->total_realisasi)}}</span>
                                                            </dd>
                                                        </dl>
                                                    </td>
                                                    <td>
                                                        <dl>
                                                            <dt>
                                                                <label class="text-darkblue">Sisa Anggaran</label>
                                                            </dt>
                                                            <dd>
                                                                <span class="text-darkblue">Rp {{number_format($kegiatan->total_sisa)}}</span>
                                                            </dd>
                                                        </dl>
                                                    </td>
                                                    <td>
                                                        <dl>
                                                            <dd>
                                                                <div class="btn-action">
                                                                    @can('tambah detail kegiatan')
                                                                    <button type="button" style="color: white;" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-tambah-detail-pr-{{$kegiatan->id}}"><i class="fas fa-plus"></i> Tambah</button>
                                                                    @endcan
                                                                    @can('ubah detail kegiatan')
                                                                    <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modal-arship-pr-{{$kegiatan->id}}"><i class="fa fa-archive"></i> Arsipkan</button>
                                                                    @endcan
                                                                    @can('hapus detail kegiatan')
                                                                    <button type="button" class="btn btn-block btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-pr-{{$kegiatan->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                                    @endcan
                                                                </div>
                                                            </dd>
                                                            @can('ubah detail kegiatan')
                                                            <dd>
                                                                <div class="btn-action">
                                                                    <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-pr-{{$kegiatan->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                                    <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-pptk-pr-{{$kegiatan->id}}"><i class="fas fa-edit"></i> Edit PPTK / Pimpinan Teknis</button>
                                                                </div>
                                                            </dd>
                                                            @endcan
                                                        </dl>
                                                    </td>
                                                </tr>
                                                <tr class="card-detail-program">
                                                    <td>
                                                        <div class="card">
                                                            <div class="taf text-darkblue px-4">{{$kegiatan->title}}</div>
                                                            <div class="row">
                                                                <div class="px-3">
                                                                    <div class=""><strong>No
                                                                            Rekening</strong></div>
                                                                    <div class=""><strong>Total Pagu</strong>
                                                                    </div>
                                                                    <div class=""><strong>Reailasi</strong>
                                                                    </div>
                                                                    <div class=""><strong>Sisa
                                                                            Anggaran</strong></div>
                                                                </div>
                                                                <div class="">
                                                                    <div class="">{{ $kegiatan->no_rek }}</div>
                                                                    <div class="">{{ number_format($kegiatan->alokasi) }}</div>
                                                                    <div class="">{{ number_format($kegiatan->total_realisasi) }}</div>
                                                                    <div class="">{{ number_format($kegiatan->total_sisa) }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="px-2">
                                                                <dl>
                                                                    <dd>
                                                                        <div class="btn-action">
                                                                            @can('tambah detail kegiatan')
                                                                            <button type="button" style="color: white;" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-tambah-detail-pr-{{$kegiatan->id}}"><i class="fas fa-plus"></i> Tambah</button>
                                                                            @endcan
                                                                            @can('ubah detail kegiatan')
                                                                            <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modal-arship-pr-{{$kegiatan->id}}"><i class="fa fa-archive"></i> Arsipkan</button>
                                                                            @endcan
                                                                            @can('hapus detail kegiatan')
                                                                            <button type="button" class="btn btn-block btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-pr-{{$kegiatan->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                                            @endcan
                                                                        </div>
                                                                    </dd>
                                                                    @can('ubah detail kegiatan')
                                                                    <dd>
                                                                        <div class="btn-action">
                                                                            <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-pr-{{$kegiatan->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                                            <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-pptk-pr-{{$kegiatan->id}}"><i class="fas fa-edit"></i> Edit PPTK / Pimpinan Teknis</button>
                                                                        </div>
                                                                    </dd>
                                                                    @endcan
                                                                </dl>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        <div id="accordion-program-detail">
                                                            <div class="justify-content-start text-darkblue" id="heading-program-detail-{{$kegiatan->id}}" data-toggle="collapse" data-target="#detail-program-{{$kegiatan->id}}">
                                                                <a href="#" class="text-lightblue">
                                                                    <h6>Lihat Daftar Paket & Anggaran</h6>
                                                                </a>
                                                            </div>
                                                            <div id="detail-program-{{$kegiatan->id}}" class="collapse" aria-labelledby="heading-program-detail-{{$kegiatan->id}}" data-parent="#accordion-program-detail">
                                                                @if ($kegiatan->detail_kegiatan->count() > 0)
                                                                @foreach ($kegiatan->detail_kegiatan as $detail)
                                                                <div class="row">
                                                                    <div class="col-12 " data-toggle="collapse">
                                                                        <table class="table table-responsive table-borderless">
                                                                            <tr id="table-detail-program">
                                                                                <td class="text-lightblue" style="width:50%;">
                                                                                    <strong>{{$detail->title}}</strong>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="text-darkblue">
                                                                                        <dl>
                                                                                            <dt>
                                                                                                <label class="text-darkblue">Pagu</label>
                                                                                            </dt>
                                                                                            <dd>
                                                                                                <span class="text-darkblue">Rp.{{ number_format((int)$detail->pagu) }}</span>
                                                                                            </dd>
                                                                                        </dl>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    @if ((int)$detail->progress > 0 && $detail->progress < 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Sedang Dikerjakan'}}</a>
                                                                                        @elseif ((int)$detail->progress == 100)
                                                                                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Sudah Selesai'}}</a>
                                                                                        @else
                                                                                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                                                                                        @endif
                                                                                </td>
                                                                                <td>
                                                                                    <div style="display: flex;justify-content: flex-end;">
                                                                                        @can('lihat detail kegiatan')
                                                                                        <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail->id]) }}" class=" btn btn-sm btn-default "><i class="fas fa-eye"></i> Lihat Detail</a>
                                                                                        @endcan
                                                                                        @can('ubah detail kegiatan')
                                                                                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-warning " style="color: #f5faff"><i class="fas fa-edit"></i> Edit Anggaran</a>
                                                                                        @endcan
                                                                                        @can('hapus detail kegiatan')
                                                                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-pg-detail-delete-pr-{{$detail->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                                                        @endcan
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="card-detail-kegiatan">
                                                                                <td>
                                                                                    <div class="card">
                                                                                        <div class="row">
                                                                                            <div class="pe-3">
                                                                                                <div class="col">
                                                                                                    <div class="text-darkblue"><strong>No Detail kegiatan</strong></div>
                                                                                                    <div class="">{{ $detail->no_detail_kegiatan }}</div>
                                                                                                </div>
                                                                                                <div class="col">
                                                                                                    <div class="text-darkblue"><strong>Judul</strong></div>
                                                                                                    <div class="">{{$detail->title}}</div>
                                                                                                </div>
                                                                                                <div class="col">
                                                                                                    <div class="text-darkblue"><strong>Pagu</strong></div>
                                                                                                    <div class="">Rp.{{ number_format((int)$detail->pagu) }}</div>
                                                                                                </div>
                                                                                                <div class="col">
                                                                                                    <div class="text-darkblue"><strong>Progress</strong></div>
                                                                                                    <div class="">
                                                                                                        @if ((int)$detail->progress > 0 && $detail->progress < 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Sedang Dikerjakan'}}</a>
                                                                                                            @elseif ((int)$detail->progress == 100)
                                                                                                            <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Sudah Selesai'}}</a>
                                                                                                            @else
                                                                                                            <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                                                                                                            @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col">
                                                                                                    @can('lihat detail kegiatan')
                                                                                                    <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail->id]) }}" class=" btn btn-sm btn-default "><i class="fas fa-eye"></i> Lihat Detail</a>
                                                                                                    @endcan
                                                                                                    @can('hapus detail kegiatan')
                                                                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-lg-detail-delete-{{$detail->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                                                                    @endcan
                                                                                                </div>
                                                                                                <div class="col">
                                                                                                    @can('ubah detail kegiatan')
                                                                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $detail->id]) }}" class="btn btn-sm btn-warning " style="color: #f5faff"><i class="fas fa-edit"></i> Edit Anggaran</a>
                                                                                                    @endcan
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="modal-pg-detail-delete-pr-{{$detail->id}}" style="padding-right: 17px; ">
                                                                    <form action="{{ route('backend.detail_kegiatan.destroy', $detail) }}" method="POST">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"><strong> Hapus Detail Kegiatan </strong></h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <span class="text-gray">Anda yakin Hapus data?</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" id="btn_update" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.modal-content -->
                                                                        </div>
                                                                    </form>
                                                                    <!-- /.modal-dialog -->
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <div class="card">
                                                                    <div class="card-header btn btn-link" data-toggle="collapse">
                                                                        <div class="card-beetween">
                                                                            <div class="text-center text-darkblue">
                                                                                <span>No data available in table</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modal-lg-edit-pr-{{$kegiatan->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.kegiatan.update', $kegiatan->id) }}" method="POST" id="update_kegiatan">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Edit Kegiatan </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Judul Kegiatan</label>
                                                                                <input type="text" class="form-control" name="title" value="{{$kegiatan->title}}" placeholder="Silahkan masukan judul Kegiatan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nomor Rekening</label>
                                                                                <input type="text" class="form-control" name="no_rek" value="{{$kegiatan->no_rek}}" placeholder="Silahkan masukan nomor rekening" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Pagu Anggaran</label>
                                                                                <input type="text" class="form-control" name="alokasi" value="{{$kegiatan->alokasi}}" placeholder="Silahkan masukan alokasi" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Tahun Kegiatan</label>
                                                                                <input type="text" class="form-control" name="tahun" value="{{$kegiatan->tahun}}" placeholder="Silahkan masukan tahun kegiatan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Program</label>
                                                                                <select name="program" id="program" class="form-control" required>
                                                                                    <option selected>-- Pilih Program --</option>
                                                                                    @foreach ($program as $value)
                                                                                    <option value="{{$value->id}}" {{$value->id == $kegiatan->program ? 'selected' : ''}}>{{$value->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nomor Rekening Program</label>
                                                                                <input type="text" class="form-control" name="no_rek_program" value="{{$kegiatan->no_rek_program}}" placeholder="Silahkan masukan nomor rekening program" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Bidang</label>
                                                                                <select name="bidang_id" id="bidang_id" class="form-control" required>
                                                                                    <option selected>-- Pilih Bidang --</option>
                                                                                    @foreach ($bidang as $value)
                                                                                    <option value="{{$value->id}}" {{$value->id == $kegiatan->bidang_id ? 'selected' : ''}}>{{$value->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Pilih Sumber Dana</label>
                                                                                <select name="sumber_dana" id="sumber_dana" class="form-control" required>
                                                                                    <option selected>-- Pilih Sumber dana --</option>
                                                                                    <option value="APBD" {{$kegiatan->sumber_dana == 'APBD' ? 'selected' : ''}}>APBD</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Tipe Paket</label>
                                                                                <select name="jenis_paket" id="jenis_paket" class="form-control" required>
                                                                                    <option selected>-- Pilih Tipe Paket --</option>
                                                                                    <option value="1" {{$kegiatan->jenis_paket == '1' ? 'selected' : ''}}>Paket Fisik</option>
                                                                                    <option value="2" {{$kegiatan->jenis_paket == '2' ? 'selected' : ''}}>Paket Non Fisik</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </form>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <div class="modal fade" id="modal-hapus-pr-{{$kegiatan->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.kegiatan.destroy', $kegiatan->id) }}" method="POST" id="delete_bidang">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Hapus Kegiatan </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <span class="text-gray">Anda yakin Hapus data?</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" id="btn_update" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </form>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <div class="modal fade" id="modal-arship-pr-{{$kegiatan->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.kegiatan.arship', $kegiatan->id) }}" method="POST" id="delete_bidang">
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Arship Kegiatan </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <span class="text-gray">Anda yakin Arship data?</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" id="btn_update" class="btn btn-success"><i class="fas fa-archive"></i> Arsipkan</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </form>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <div class="modal fade" id="modal-lg-tambah-detail-pr-{{$kegiatan->id}}" style="padding-right: 17px; ">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><strong> Tambah Detail Kegiatan </strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('backend.detail_kegiatan.store') }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Judul</label>
                                                                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Penyedia Jasa</label>
                                                                                <select class="form-control" name="penyedia_jasa_id" id="penyedia_jasa_id" required>
                                                                                    <option value="">-- Pilih Penyedia Jasa --</option>
                                                                                    @foreach ($penyedia_jasa as $item)
                                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nomor Kontrak</label>
                                                                                <input type="text" hidden="true" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                                                                <input type="text" class="form-control" name="no_kontrak" placeholder="Silahkan masukan nomor kontrak" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Jenis Pengadaan</label>
                                                                                <input type="text" class="form-control" name="jenis_pengadaan" placeholder="Silahkan masukan jenis pengadaan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Awal Kontrak</label>
                                                                                <input type="date" class="form-control" name="awal_kontrak" placeholder="Silahkan masukan awal kontrak" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Akhir Kontrak</label>
                                                                                <input type="date" class="form-control" name="akhir_kontrak" placeholder="Silahkan masukan akhir kontrak" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Target</label>
                                                                                <input type="text" class="form-control" name="target" placeholder="Silahkan masukan target satuan hari" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Alamat</label>
                                                                                <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="5"></textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Latitude</label>
                                                                                <input type="text" class="form-control" name="latitude" placeholder="Silahkan masukan latitude" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Longitude</label>
                                                                                <input type="text" class="form-control" name="longitude" placeholder="Silahkan masukan longitude" required>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <div class="modal fade" id="modal-lg-edit-pptk-pr-{{$kegiatan->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.kegiatan.pptk', $kegiatan->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Edit PPTK / Pimpinan Teknis </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <h2>PPTK</h2>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nama</label>
                                                                                <input type="text" class="form-control" name="pptk_name" value="{{$kegiatan->penanggung->pptk_name ?? ''}}" placeholder="Silahkan masukan judul Kegiatan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">NIP</label>
                                                                                <input type="text" class="form-control" name="pptk_name" value="{{$kegiatan->penanggung->pptk_nip ?? ''}}" placeholder="Silahkan masukan NIP" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Email</label>
                                                                                <input type="text" class="form-control" name="pptk_email" value="{{$kegiatan->penanggung->pptk_email ?? ''}}" placeholder="Silahkan masukan nomor rekening" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Telpon</label>
                                                                                <input type="text" class="form-control" name="pptk_telpon" value="{{$kegiatan->penanggung->pptk_telpon ?? ''}}" placeholder="Silahkan masukan tahun kegiatan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Bidang</label>
                                                                                <select name="pptk_bidang_id" id="pptk_bidang_id" class="form-control" required>
                                                                                    <option selected>-- Pilih Bidang --</option>
                                                                                    @foreach ($bidang as $value)
                                                                                    <option value="{{$value->id}}" {{$kegiatan->penanggung ? $kegiatan->penanggung->pptk_bidang_id == $value->id ? 'selected' : ''  : ''}}>{{$value->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <h2>Pimpinan Teknis</h2>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nama</label>
                                                                                <input type="text" class="form-control" name="ppk_name" value="{{$kegiatan->penanggung->ppk_name ?? ''}}" placeholder="Silahkan masukan judul Kegiatan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">NIP</label>
                                                                                <input type="text" class="form-control" name="ppk_nip" value="{{$kegiatan->penanggung->ppk_nip ?? ''}}" placeholder="Silahkan masukan NIP" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Email</label>
                                                                                <input type="text" class="form-control" name="ppk_email" value="{{$kegiatan->penanggung->ppk_email ?? ''}}" placeholder="Silahkan masukan nomor rekening" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Telpon</label>
                                                                                <input type="text" class="form-control" name="ppk_telpon" value="{{$kegiatan->penanggung->ppk_telpon ?? ''}}" placeholder="Silahkan masukan tahun kegiatan" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Bidang</label>
                                                                                <select name="ppk_bidang_id" id="ppk_bidang_id" class="form-control" required>
                                                                                    <option selected>-- Pilih Bidang --</option>
                                                                                    @foreach ($bidang as $value)
                                                                                    <option value="{{$value->id}}" {{$kegiatan->penanggung ? $kegiatan->penanggung->ppk_bidang_id == $value->id ? 'selected' : ''  : ''}}>{{$value->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </form>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>
</div>
</div>
<div class="modal fade" id="modal-lg-create" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Data Kegiatan (Manual) </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.kegiatan.store') }}" method="POST" id="submit_kegiatan">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Kode Kegiatan</label>
                                <input type="text" class="form-control" name="no_rek_program" placeholder="Silahkan masukan nomor rekening program" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nomor Rekening</label>
                                <input type="text" class="form-control" name="no_rek" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Pagu Anggaran</label>
                                <input type="text" class="form-control" name="alokasi" placeholder="Silahkan masukan alokasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tahun Kegiatan</label>
                                <input type="text" class="form-control" name="tahun" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Program</label>
                                <select name="program" id="program" class="form-control" required>
                                    <option selected>-- Pilih Program --</option>
                                    @foreach ($program as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="text-darkblue">Bidang</label>
                                <select name="bidang_id" id="bidang_id" class="form-control" required>
                                    <option selected>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Pilih Sumber Dana</label>
                                <select name="sumber_dana" id="sumber_dana" class="form-control" required>
                                    <option selected>-- Pilih Sumber dana --</option>
                                    @foreach ($sumber_dana as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tipe Paket</label>
                                <select name="jenis_paket" id="jenis_paket" class="form-control" required>
                                    <option selected>-- Pilih Tipe Paket --</option>
                                    <option value="1">Paket Fisik</option>
                                    <option value="2">Paket Non Fisik</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" id="btn_submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-lg-dana" style="padding-right: 17px; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> List Sumber Dana </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="dana" checked="">
                            <label for="dana" class="custom-control-label">APBD</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-lg-print" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Laporan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label class="text-darkblue">Pilih Bulan</label>
                            <select name="bulan" id="bulan_laporan" class="form-control" required>
                                <option value="" selected>-- Pilih Bulan --</option>
                                <option value="januari">Januari</option>
                                <option value="februari">Februari</option>
                                <option value="maret">Maret</option>
                                <option value="april">April</option>
                                <option value="mei">Mei</option>
                                <option value="juni">Juni</option>
                                <option value="juli">Juli</option>
                                <option value="agustus">Agustus</option>
                                <option value="september">September</option>
                                <option value="oktober">Oktober</option>
                                <option value="november">November</option>
                                <option value="desember">Desember</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-darkblue">Pilih Tahun</label>
                            <select name="tahun" id="tahun_laporan" class="form-control" required>
                                <option value="" selected>-- Pilih Tahun --</option>
                                @for ($i = 0; $i < 5; $i++) <option value="{{date('Y')-$i}}">{{((int)date('Y'))-$i}}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-primary" onclick="cetakLaporan()" data-dismiss="modal">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    $(function() {
        $("#btn_submit").on("click", function() {
            $("#submit_kegiatan").submit();
        });

    });

    function getKegiatan(id) {
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({

            url: `{{route('backend.kegiatan.getKegiatan')}}`,
            type: "GET",
            cache: false,
            data: {
                "id": id,
                "_token": token
            },
            success: function(response) {
                console.log("wkwk", id);
                if (response.success) {
                    if (response.data.length > 0) {
                        $('#list-product').removeClass('display-unactive');
                        $('#list-product').addClass('display-active');
                        console.log(response.data);

                        $('#spinner').addClass('display-unactive');
                    } else {
                        $('#spinner').addClass('display-unactive');
                        $('#blank-product').removeClass('display-unactive');
                        $('#blank-product').addClass('display-active');
                    }
                } else {
                    console.log(response.success);
                }
            },
            error: function(response) {
                console.log('error');
            }
        });
    }

    function cetakLaporan() {
        var bulan = $('#bulan_laporan').val();
        var tahun = $('#tahun_laporan').val();
        window.location = `/backend/kegiatan/laporan?bulan=${bulan}&tahun=${tahun}`
    }
</script>

<script>
    function postVerifikasi() {

    }
</script>
<script type="text/javascript">
    // Tulang Bawang, Lampung
    var startlat = -4.3975495;
    var startlon = 105.3726319;
    var map = L.map('mapDetail').setView([startlat, startlon], 10);
    setTimeout(function() {
        map.invalidateSize(true)
    }, 3000);
    // Tambahkan layer peta dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    setTimeout(function() {
        map.invalidateSize(true)
    }, 5000);
    map.on("click", function(event) {
        map.eachLayer((layer) => {
            if (layer instanceof L.Marker) {
                layer.remove();
            }
        });
        var layer = L.marker(event.latlng).addTo(map);
        var lat = event.latlng.lat;
        var lng = event.latlng.lng;
        $("#latitude").val(lat);
        $("#longitude").val(lng);
    });
</script>
@endsection
