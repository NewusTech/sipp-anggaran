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
                            <div class="col-5">
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
            <div class="card-body">
                <div class="table-responsive p-0 text-center">
                    <h4><strong>RELASI LAPORAN KEUANGAN DINAS PUPR</strong></h4>
                    <h4><strong>KABUPATEN TULANG BAWANG BARAT TAHUN {{$tahun ? $tahun : 'SEMUA TAHUN'}}</strong></h4>
                    <h4><strong>BULAN {{$bulan ? strtoupper($bulan) : '-'}}</strong></h4>
                    <table class="table table-bordered">
                        <thead class="text-bold">
                            <tr>
                                <td rowspan="3">Program/Kegiatan/Sub Kegiatan</td>
                                <td colspan="15">Anggaran</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total</td>
                                <td colspan="3">Belanja Operasi</td>
                                <td colspan="3">Belanja Modal</td>
                                <td colspan="3">Belanja Tidak Terduga</td>
                                <td colspan="3">Belanja Transfer</td>
                            </tr>
                            <tr>
                                <td>Anggaran</td>
                                <td>Realisasi</td>
                                <td>%</td>
                                <td>Anggaran</td>
                                <td>Realisasi</td>
                                <td>%</td>
                                <td>Anggaran</td>
                                <td>Realisasi</td>
                                <td>%</td>
                                <td>Anggaran</td>
                                <td>Realisasi</td>
                                <td>%</td>
                                <td>Anggaran</td>
                                <td>Realisasi</td>
                                <td>%</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($details->count() > 0)
                            @foreach ($details as $item)
                            <tr>
                                <td>{{$item->program_title.'/'.$item->kegiatan_title.'/'.$item->sub_kegiatan_title}}</td>
                                <td>Rp.{{number_format($item->alokasi)}}</td>
                                <td>Rp.{{number_format($item->pagu)}}</td>
                                <td>{{$item->pagu ? round(($item->pagu/$item->alokasi)*100,1) : 0}}%</td>
                                <td>Rp.{{number_format($item->anggaran_belanja_operasi)}}</td>
                                <td>Rp.{{number_format($item->pengambilan_belanja_operasi)}}</td>
                                <td>{{$item->pengambilan_belanja_operasi ? round(($item->pengambilan_belanja_operasi/$item->anggaran_belanja_operasi)*100,1) : 0}}%</td>
                                <td>Rp.{{number_format($item->anggaran_belanja_modal)}}</td>
                                <td>Rp.{{number_format($item->pengambilan_belanja_modal)}}</td>
                                <td>{{$item->pengambilan_belanja_modal ? round(($item->pengambilan_belanja_modal/$item->anggaran_belanja_modal)*100,1) : 0}}%</td>
                                <td>Rp.{{number_format($item->anggaran_belanja_tak_terduga)}}</td>
                                <td>Rp.{{number_format($item->pengambilan_belanja_tak_terduga)}}</td>
                                <td>{{$item->pengambilan_belanja_tak_terduga ? round(($item->pengambilan_belanja_tak_terduga/$item->anggaran_belanja_tak_terduga)*100,1) : 0}}%</td>
                                <td>Rp.{{number_format($item->anggaran_belanja_transfer)}}</td>
                                <td>Rp.{{number_format($item->pengambilan_belanja_transfer)}}</td>
                                <td>{{$item->pengambilan_belanja_transfer ? round(($item->pengambilan_belanja_transfer/$item->anggaran_belanja_transfer)*100,1) : 0}}%</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="16"><span>No data available in table</span></td>
                            </tr>
                            @endif
                            <tr class="text-bold">
                                <td>Jumlah Belanja Operasi</td>
                                <td>Rp.{{number_format($details->sum('anggaran_belanja_operasi'))}}</td>
                                <td>Rp.{{number_format($details->sum('pengambilan_belanja_operasi'))}}</td>
                                <td>{{$details->sum('pengambilan_belanja_operasi') ? round(($details->sum('pengambilan_belanja_operasi')/$details->sum('anggaran_belanja_operasi'))*100, 1) : 0 }}%</td>
                                <td colspan="12"></td>
                            </tr>
                            <tr class="text-bold">
                                <td>Jumlah Belanja Modal</td>
                                <td>Rp.{{number_format($details->sum('anggaran_belanja_modal'))}}</td>
                                <td>Rp.{{number_format($details->sum('pengambilan_belanja_modal'))}}</td>
                                <td>{{$details->sum('pengambilan_belanja_modal') ? round(($details->sum('pengambilan_belanja_modal')/$details->sum('anggaran_belanja_modal'))*100, 1): 0}}%</td>
                                <td colspan="12"></td>
                            </tr>
                            <tr class="text-bold">
                                <td>Jumlah Belanja Tidak Terduga</td>
                                <td>Rp.{{number_format($details->sum('anggaran_belanja_tak_terduga'))}}</td>
                                <td>Rp.{{number_format($details->sum('pengambilan_belanja_tak_terduga'))}}</td>
                                <td>{{$details->sum('pengambilan_belanja_tak_terduga') ? round(($details->sum('pengambilan_belanja_tak_terduga')/$details->sum('anggaran_belanja_tak_terduga'))*100, 1): 0}}%</td>
                                <td colspan="12"></td>
                            </tr>
                            <tr class="text-bold">
                                <td>Jumlah Belanja Transfer</td>
                                <td>Rp.{{number_format($details->sum('anggaran_belanja_transfer'))}}</td>
                                <td>Rp.{{number_format($details->sum('pengambilan_belanja_transfer'))}}</td>
                                <td>{{$details->sum('pengambilan_belanja_transfer') ? round(($details->sum('pengambilan_belanja_transfer')/$details->sum('anggaran_belanja_transfer'))*100, 1): 0}}%</td>
                                <td colspan="12"></td>
                            </tr>
                            <tr class="text-bold">
                                <td>Total</td>
                                <td>Rp.{{number_format($details->sum('alokasi'))}}</td>
                                <td>Rp.{{number_format($details->sum('pagu'))}}</td>
                                <td>{{$details->sum('pagu') ? round(($details->sum('pagu')/$details->sum('alokasi'))*100, 1): 0}}%</td>
                                <td colspan="12"></td>
                            </tr>
                        </tbody>
                    </table>
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
