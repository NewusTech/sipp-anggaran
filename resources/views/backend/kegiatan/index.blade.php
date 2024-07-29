@extends('layouts.main')

@section('title', 'Kegiatan')
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

    @media(max-width: 576px) {
        #tableKegiatanPekerjaan {
            display: none;
        }

        #accordionKegiatan {
            display: inherit;
        }
    }

    @media (min-width: 576px) {
        #accordionKegiatan {
            display: none;
        }
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
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('error') }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="card w-100">
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
                            @can('tambah kegiatan')
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-lg-create">Manual</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-import">Import</a>
                                </div>
                            </div>
                            @include('backend.kegiatan._modal_import_kegiatan')
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
        </ul>

        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade show active" id="custom-content-below-bidang" role="tabpanel" aria-labelledby="custom-content-below-bidang-tab">
                <div class="row">
                    <div class="col-12">
                        <div id="accordion">
                            @foreach ($bidang as $item)
                            <div class="card w-100">
                                <div class="p-3">
                                    <div id="heading-{{$item->id}}" class="card-header p-2 rounded heading-kegiatan" data-toggle="collapse" data-target="#collapse-{{$item->id}}" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="card-table">
                                            <div class="taf text-white">
                                                <strong>{{$item->name}}</strong>
                                            </div>
                                            <div class="card-table-cell tar">
                                                <button type="button" class=" btn btn-sm btn-light rounded text-darkblue" style="width: 120pt"><strong>Total Kegiatan : {{$item->kegiatan->count()}}</strong></button>
                                                <button type="button" class="btn btn-sm btn-light rounded text-darkblue" style="width: 200pt"><strong>Total Pagu : Rp {{number_format($item->totalPagu)}}</strong></button>
                                            </div>
                                        </div>
                                    </div>
                                    @include('backend.kegiatan._collapse_kegiatan')
                                    <table id="tableKegiatanPekerjaan" class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center" colspan="3">Kode</th>
                                                <th class="text-center" rowspan="2">Pagu Anggaran</th>
                                                <th class="text-center" rowspan="2">Nilai Kontrak</th>
                                                <th class="text-center" rowspan="2">Progres</th>
                                                <th class="text-center" rowspan="2">Verifikasi Admin</th>
                                                <th class="text-center" rowspan="2">Komentar</th>
                                                <th class="text-center" rowspan="2">Verifikasi Pengawas</th>
                                                <th class="text-center" rowspan="2">Komentar</th>
                                                <th class="text-center" rowspan="2">Aksi</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Kegiatan</th>
                                                <th class="text-center">Sub Kegiatan</th>
                                                <th class="text-center">Pekerjaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->kegiatan as $kegiatan)
                                            @if ($kegiatan->is_arship == 0)
                                            <tr class="table-success">
                                                <td class="text-center">{{$kegiatan->title}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center"></td>
                                                <td class="text-center" colspan="4"></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="btn-action">
                                                            @can('tambah detail kegiatan')
                                                            <button type="button" style="color: white;" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-tambah-detail-{{$kegiatan->id}}"><i class="fas fa-plus"></i></button>
                                                            @endcan
                                                            @can('ubah kegiatan')
                                                            <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$kegiatan->id}}"><i class="fas fa-edit"></i></button>
                                                            @endcan
                                                            @can('hapus kegiatan')
                                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-kegiatan-{{$kegiatan->id}}"><i class="fas fa-trash"></i></button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('backend.kegiatan._modal_delete_kegiatan')
                                            @include('backend.kegiatan._modal_update_pptk')
                                            @include('backend.kegiatan._modal_add_detail')
                                            @foreach($kegiatan->subKegiatan as $subKegiatan)
                                                <tr>
                                                    <td class="table-success"></td>
                                                    <td class="text-left table-info" colspan="10">{{$subKegiatan->title}}</td>
                                                </tr>
                                            @include('backend.kegiatan._collapse_sub_kegiatan')
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
                <form action="{{ route('backend.detail_kegiatan.store') }}" method="POST" id="submit_kegiatan">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
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
                                <label class="text-darkblue">Kegiatan</label>
                                <select name="kegiatan_id" id="kegiatan" class="form-control" required>
                                    <option selected>-- Pilih Kegiatan --</option>
                                    @foreach ($kegiatans as $value)
                                    <option value="{{$value->id}}">{{$value->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Sub Kegiatan</label>
                                <select name="sub_kegiatan_id" id="subKegiatan" class="form-control" required>
                                    <option selected>-- Pilih Sub Kegiatan --</option>
                                    @foreach ($subKegiatans as $value)
                                    <option value="{{$value->id}}">{{$value->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nama Pekerjaan</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul Pekerjaan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Pagu Anggaran</label>
                                <input type="number" class="form-control" name="pagu" placeholder="Silahkan masukan Pagu Anggaran" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tahun Kegiatan</label>
                                <input type="text" class="form-control" name="tahun" placeholder="Silahkan masukan tahun kegiatan" required>
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
                                <label class="text-darkblue">Jenis Pengadaan</label>
                                <input type="text" class="form-control" name="jenis_pengadaan" placeholder="Silahkan masukan jenis Pengadaan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Metode Pemilihan</label>
                                <input type="text" class="form-control" name="metode_pemilihan" placeholder="Silahkan masukan Metode Pemilihan" required>
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

    function getKegiatanByProgram(id) {
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({

            url: `{{route('backend.kegiatan.getKegiatanbyprogram')}}`,
            type: "GET",
            cache: false,
            data: {
                "id": id,
                "_token": token
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.length > 0) {
                        console.log(response.data);
                    } else {}
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
    let idBidang = @json($bidang->map(function($item) {
        return $item->id;
    }));
    let headingColors = ["#6097d3", "#dc6789", "#df8d72", "#afc28a", "#49c3a3", "#715fa5", "#027ADC", "#027ADC", "#027ADC", "#027ADC", "#027ADC"]
    for (let index = 0; index < idBidang.length; index++) {
        let idHeadings = document.getElementById(`heading-${idBidang[index]}`);
        idHeadings.style.backgroundColor = headingColors[index];

    }
</script>
@endsection
