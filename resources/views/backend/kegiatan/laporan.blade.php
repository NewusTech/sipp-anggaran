@extends('layouts.main')

@section('title', 'Pengaturan Informasi Utama')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<style>
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        padding: 8px;
    }
</style>
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backend.kegiatan.index') }}">{{ __('Kegiatan') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Laporan') }}</li>
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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            </div>
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Laporan</a>
                </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-1">
                                <select name="bulan" id="bulan_laporan" class="form-control">
                                    <option value="" selected>-- Pilih Bulan --</option>
                                    <option value="januari" {{$bulan == "januari"?"selected":""}}>Januari</option>
                                    <option value="februari" {{$bulan == "februari"?"selected":""}}>Februari</option>
                                    <option value="maret" {{$bulan == "maret"?"selected":""}}>Maret</option>
                                    <option value="april" {{$bulan == "april"?"selected":""}}>April</option>
                                    <option value="mei" {{$bulan == "mei"?"selected":""}}>Mei</option>
                                    <option value="juni" {{$bulan == "juni"?"selected":""}}>Juni</option>
                                    <option value="juli" {{$bulan == "juli"?"selected":""}}>Juli</option>
                                    <option value="agustus" {{$bulan == "agustus"?"selected":""}}>Agustus</option>
                                    <option value="september" {{$bulan == "september"?"selected":""}}>September</option>
                                    <option value="oktober" {{$bulan == "oktober"?"selected":""}}>Oktober</option>
                                    <option value="november" {{$bulan == "november"?"selected":""}}>November</option>
                                    <option value="desember" {{$bulan == "desember"?"selected":""}}>Desember</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select name="bidang" id="bidangId" class="form-control">
                                    <option value="" selected>-- Pilih Bidang --</option>
                                    @foreach (Auth::user()->bidang_id == null ? $listBidang : $bidang as $item)
                                    <option value="{{$item->id}}" {{$requestBidang == $item->id?"selected":""}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1">
                                <select name="tahun" id="tahun_laporan" class="form-control">
                                    <option value="" selected>-- Pilih Tahun --</option>
                                    @for ($i = 0; $i < 5; $i++) <option value="{{date('Y')-$i}}" {{$tahun == (date('Y')-$i) ? "selected" : ""}}>{{((int)date('Y'))-$i}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="search" class="form-control" name="search" placeholder="Cari Kegiatan ..." value="{{ request('search') }}">
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                            <div class="col-2">
                                <a href="/backend/kegiatan/laporan/download?bulan={{$bulan}}&tahun={{$tahun}}&requestBidang={{$requestBidang}}" class="btn btn-primary"> <i class="fas fa-download"></i> Download</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card -->
        <div class="card">
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="col text-center">
                    <h4><strong>RELASI LAPORAN KEGIATAN DINAS PUPR</strong></h4>
                    <h4><strong>KABUPATEN TULANG BAWANG BARAT </strong></h4>
                </div>
                <div class="col mt-3">
                    <table class="table table-bordered align-middle">
                        <thead class="text-bold">
                            <tr>
                                <td rowspan="2">No</td>
                                <td rowspan="2">No Kontrak</td>
                                <td rowspan="2">Nama Pekerjaan</td>
                                <td rowspan="2">Perusahaan</td>
                                <td rowspan="2">Tgl Kontrak</td>
                                <td rowspan="2">Nilai Kontrak</td>
                                <td rowspan="2">Panjang Penanganan(KM)</td>
                                <td rowspan="2">Lebar Penanganan(M)</td>
                                <td rowspan="2">Jenis Penanganan</td>
                                <td rowspan="2">Nomor SPMK</td>
                                <td rowspan="2">Tanggal Akhir Kontrak</td>
                                <td rowspan="2">Progress</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($bidang->count() > 0)
                            @foreach ($bidang as $item)
                                @foreach ($item->kegiatan as $kegiatan)
                                <tr class="bg-secondary">
                                    <td>{{$loop->iteration}}</td>
                                    <td colspan="11">{{$kegiatan->title}}</td>
                                </tr>
                                @if ( count($kegiatan->detail) > 0)
                                    @foreach ($kegiatan->detail as $detail)
                                        <tr>
                                            <td></td>
                                            <td>{{ $detail->no_kontrak }}</td>
                                            <td>{{ $detail->title }}</td>
                                            <td>{{ $detail->penyedia_jasa }}</td>
                                            <td>{{ \Carbon\Carbon::parse($detail->awal_kontrak )->format('d-m-Y') }}</td>
                                            <td>{{ $detail->nilai_kontrak }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>{{ $detail->no_spmk }}</td>
                                            <td>{{ \Carbon\Carbon::parse($detail->akhir_kontrak )->format('d-m-Y') }}</td>
                                            <td>{{ $detail->progress }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="16"><span>Tidak Ada Data</span></td>
                                    </tr>
                                @endif  
                                @endforeach
                            @endforeach
                            @else
                            <tr>
                                <td colspan="16"><span>No data available in table</span></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script>
    $(function() {

    });
</script>
@endsection