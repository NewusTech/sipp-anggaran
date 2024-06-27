@extends('layouts.main')

@section('title', 'Pengaturan Informasi Utama')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
                                <select name="bulan" id="bulan_laporan" class="form-control" required>
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
                                <select name="bidang" id="bidangId" class="form-control" required>
                                    <option value="" selected>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $item)
                                    <option value="{{$item->id}}" {{Auth::user()->bidang_id == $item->id?"selected":""}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1">
                                <select name="tahun" id="tahun_laporan" class="form-control" required>
                                    <option value="" selected>-- Pilih Tahun --</option>
                                    @for ($i = 0; $i < 5; $i++) <option value="{{date('Y')-$i}}" {{$tahun == (date('Y')-$i) ? "selected" : ""}}>{{((int)date('Y'))-$i}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-1">
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                            <div class="col-2">
                                <a href="/backend/kegiatan/laporan/download?bulan={{$bulan}}&tahun={{$tahun}}" class="btn btn-primary"> <i class="fas fa-download"></i> Download</a>
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
                    <h4><strong>RELASI LAPORAN KEUANGAN DINAS PUPR</strong></h4>
                    <h4><strong>KABUPATEN TULANG BAWANG BARAT TAHUN {{$tahun ? $tahun : 'SEMUA TAHUN'}}</strong></h4>
                    <h4><strong>BULAN {{$bulan ? strtoupper($bulan) : '-'}}</strong></h4>
                </div>
                <div class="col">
                    <table class="table table-bordered">
                        <thead class="text-bold">
                            <tr>
                                <td>No</td>
                                <td>Tahun / Kontrak</td>
                                <td>Program/Kegiatan/Sub Kegiatan</td>
                                <td>Nama Paket</td>
                                <td>Pagu</td>
                                <td>Anggaran</td>
                                <td>Realisasi</td>
                                <td>Sisa</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($bidang->count() > 0)
                            @foreach ($bidang as $item)
                            @foreach ($item->kegiatan as $kegiatan)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{\Carbon\Carbon::parse($kegiatan->created_at)->format('Y')}}</td>
                                <td>{{$kegiatan->title}}</td>
                                <td>Fisik</td>
                                <td>Rp.{{number_format($kegiatan->alokasi)}}</td>
                                <td>Rp.10.000.000 (dummy data)</td>
                                <td>{{$kegiatan->no_rek}}</td>
                                <td>%</td>
                            </tr>
                            @foreach ($kegiatan->detail as $detail)
                            <tr>
                                <td></td>
                                <td>{{\Carbon\Carbon::parse($detail->awal_kontrak )->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($detail->akhir_kontrak)->format('d-m-Y')}}</td>
                                <td>{{$detail->title}}</td>
                                <td>Fisik</td>
                                <td>Rp.{{number_format($detail->pagu)}}</td>
                                <td>Rp.10.000.000 (dummy data)</td>
                                <td>{{$detail->nomor_kontrak}}</td>
                                <td>%</td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            @else
                            <tr>
                                <td colspan="16"><span>No data available in table</span></td>
                            </tr>
                            @endif
                            <tr class="text-bold">
                                <td>Total</td>
                                <td>Rp.{{number_format($details->sum('alokasi'))}}</td>
                                <td>Rp.{{number_format($details->sum('pagu'))}}</td>
                            </tr>
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
