@extends('layouts.main')

@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .leaflet-container {
        height: 500px;
        max-width: 100%;
        border-radius: 15px;
    }
</style>
@endsection
@section('main')
<form action="{{route('backend.dashboard.index')}}" method="GET">
    <div class="row">
        <div class=" mx-3 col-2 col-md-1 col-lg-1">
            <label for="filter">Filter Tahun</label>
        </div>
        <div class="col-3">
            <select name="tahun" id="tahun" class="form-control" onchange="this.form.submit()" required>
                <option value="" selected>-- Pilih Tahun --</option>
                @for ($i = 0; $i < 5; $i++) <option value="{{date('Y')-$i}}" {{request()->get('tahun') == date('Y')-$i ? 'selected' : ''}}>{{((int)date('Y'))-$i}}</option>
                    @endfor
            </select>
        </div>
    </div>
</form>
@can('lihat total keuangan')
<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info pattern rounded">
            <div class="inner">
                <p>{{ __('Total Pagu') }}</p>
                <h3> Rp. {{ number_format($total_pagu) }}</h3>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-danger rounded">
            <div class="inner">
                <p>{{ __('Total Realisasi') }}</p>
                <h3> Rp. {{ number_format($total_realisasi) }}</h3>
            </div>
            <div class="icon">
                <i class="fas fa-circle-notch"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success rounded">
            <div class="inner">
                <p>{{ __('Total Sisa Anggaran') }}</p>
                <h3> Rp. {{ number_format($total_sisa) }}</h3>
            </div>
            <div class="icon">
                <i class="fas fa-circle-notch"></i>
            </div>
        </div>
    </div>
</div>
@endcan
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-action-right">
                    <button type="button" onclick="downloadImage()" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</button>
                </div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> Progres Keuangan {{request()->get('tahun') ? request()->get('tahun') : "2024"}}</strong></h4>
                </div>
                <div class="chart">
                    <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-action-right">
                    <button type="button" onclick="downloadImage()" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</button>
                </div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> Progres Fisik {{request()->get('tahun') ? request()->get('tahun') : "2024"}}</strong></h4>
                </div>
                <div class="chart">
                    <canvas id="chartFisik" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row sm">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="mapDashboard">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="text-darkblue"><strong> PROGRESS PEKERJAAN TAHUN {{request()->get('tahun') ? request()->get('tahun') : "2024"}}</strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Paket Fisik ({{$fisik->count()}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="non-fisik-tab" data-toggle="pill" href="#non-fisik" role="tab" aria-controls="non-fisik" aria-selected="true">Paket Non-Fisik ({{$nonfisik->count()}})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kegiatan-tab" data-toggle="pill" href="#kegiatan" role="tab" aria-controls="kegiatan" aria-selected="true">Kegiatan ({{$kegiatan->count()}})</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-action-right">
                                    <a href="{{route('backend.download.fisik')}}" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="row overflow-auto">
                            <div class="col-12">
                                <table id="progress" class="table ">
                                    <thead>
                                        <tr>
                                            <th style="padding:1rem 2.25rem;">Nama Paket</th>
                                            <th style="text-align: center">Bidang</th>
                                            <th style="text-align: center">PPTK</th>
                                            <th style="text-align: center">Realisasi (Rp.)</th>
                                            <th style="text-align: center">Update</th>
                                            <th style="text-align: center">Progress</th>
                                            <th style="text-align: center">Masa Kerja</th>
                                            <th style="text-align: center">Status</th>
                                            <th style="text-align: center">Kontraktor</th>
                                            <th style="text-align: center">Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fisik as $itemA)
                                        <tr>
                                            <td>{{$itemA->title ?? '-'}}</td>
                                            <td style="text-align: center">{{$itemA->bidang_name ?? '-'}}</td>
                                            <td style="text-align: center">{{$itemA->pptk_name ?? '-'}}</td>
                                            <td style="text-align: center">Rp.{{number_format($itemA->realisasi)}}</td>
                                            <td style="color: red;">{{$itemA->updated_at ? $itemA->updated_at->format('d-m-Y') : '-'}}</td>
                                            <td style="text-align: center">
                                                @if ((int)$itemA->progress > 0 && $itemA->progress < 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$itemA->progress}}% ({{'Sedang Dikerjakan'}})</a>
                                                    @elseif ((int)$itemA->progress == 100)
                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$itemA->progress}}% ({{'Sudah Selesai'}})</a>
                                                    @else
                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{0}}% ({{'Belum Mulai'}})</a>
                                                    @endif
                                            </td>
                                            <td style="text-align: center">{{(strtotime($itemA->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</td>
                                            <td style="text-align: center">
                                                @if ((int)$itemA->progress >= 1 && $itemA->progress < 40) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-danger rounded btn-block">{{'Kritis'}}</a>
                                                    @elseif ((int)$itemA->progress >= 40 && $itemA->progress < 60) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-warning text-white rounded btn-block">{{'Terlambat'}}</a>
                                                        @elseif ((int)$itemA->progress >= 60 && $itemA->progress < 80) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Wajar'}}</a>
                                                            @elseif ((int)$itemA->progress >= 80 && $itemA->progress <= 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Baik'}}</a>
                                                                @else
                                                                <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                                                                @endif
                                            </td>
                                            <td>{{$itemA->penyedia_jasa ?? '-'}}</td>
                                            <td>
                                                <a target="_blank" href="https://maps.google.com/maps?&z=13&mrt=yp&t=m&q={{ $itemA->latitude }}+{{ $itemA->longitude }}">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </a> 
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="non-fisik" role="tabpanel" aria-labelledby="non-fisik-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-action-right">
                                    <a href="{{route('backend.download.nonfisik')}}" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="row overflow-auto">
                            <div class="col-12">
                                <table id="progress-non-fisik" class="table " style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th style="padding:1rem 2.25rem;">Nama Paket</th>
                                            <th style="text-align: center">Bidang</th>
                                            <th style="text-align: center">PPTK</th>
                                            <th style="text-align: center">Realisasi (Rp.)</th>
                                            <th style="text-align: center">Update</th>
                                            <th style="text-align: center">Progress</th>
                                            <th style="text-align: center">Masa Kerja</th>
                                            <th style="text-align: center">Status</th>
                                            <th style="text-align: center">Kontraktor</th>
                                            <th style="text-align: center">Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nonfisik as $itemB)
                                        <tr>
                                            <td>{{$itemB->title ?? '-'}}</td>
                                            <td style="text-align: center">{{$itemB->bidang_name ?? '-'}}</td>
                                            <td style="text-align: center">{{$itemB->pptk_name ?? '-'}}</td>
                                            <td style="text-align: center">Rp.{{number_format($itemB->realisasi)}}</td>
                                            <td style="color: red;">{{$itemB->updated_at ? $itemB->updated_at->format('d-m-Y') : '-'}}</td>
                                            <td style="text-align: center">
                                                @if ((int)$itemB->progress > 0 && $itemB->progress < 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$itemB->progress}}% ({{'Sedang Dikerjakan'}})</a>
                                                    @elseif ((int)$itemB->progress == 100)
                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$itemB->progress}}% ({{'Sudah Selesai'}})</a>
                                                    @else
                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{0}}% ({{'Belum Mulai'}})</a>
                                                    @endif
                                            </td>
                                            <td style="text-align: center">{{(strtotime($itemB->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</td>
                                            <td style="text-align: center">
                                                @if ((int)$itemB->progress >= 1 && $itemB->progress < 40) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-danger rounded btn-block">{{'Kritis'}}</a>
                                                    @elseif ((int)$itemB->progress >= 40 && $itemB->progress < 60) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-warning text-white rounded btn-block">{{'Terlambat'}}</a>
                                                        @elseif ((int)$itemB->progress >= 60 && $itemB->progress < 80) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Wajar'}}</a>
                                                            @elseif ((int)$itemB->progress >= 80 && $itemB->progress <= 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Baik'}}</a>
                                                                @else
                                                                <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemB->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                                                                @endif
                                            </td>
                                            <td>{{$itemB->penyedia_jasa ?? '-'}}</td>
                                            <td>
                                                <a target="_blank" href="https://maps.google.com/maps?&z=13&mrt=yp&t=m&q={{ $itemA->latitude }}+{{ $itemA->longitude }}">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </a> 
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="kegiatan" role="tabpanel" aria-labelledby="kegiatan-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-action-right">
                                    <a href="{{route('backend.download.kegiatan')}}" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="row overflow-auto">
                            <div class="col-12">
                                <table id="progress-kegiatan" class="table " style="width: 100% !important">
                                    <thead>
                                        <tr>
                                            <th style="padding:1rem 2.25rem;">Nama Paket</th>
                                            <th style="text-align: center">Bidang</th>
                                            <th style="text-align: center">PPTK</th>
                                            <th style="text-align: center">Realisasi (Rp.)</th>
                                            <th style="text-align: center">Update</th>
                                            <th style="text-align: center">Progress</th>
                                            <th style="text-align: center">Masa Kerja</th>
                                            <th style="text-align: center">Status</th>
                                            <th style="text-align: center">Kontraktor</th>
                                            <th style="text-align: center">Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kegiatan as $itemC)
                                        <tr>
                                            <td>{{$itemC->title ?? '-'}}</td>
                                            <td style="text-align: center">{{$itemC->bidang_name ?? '-'}}</td>
                                            <td style="text-align: center">{{$itemC->pptk_name ?? '-'}}</td>
                                            <td style="text-align: center">Rp.{{number_format($itemC->realisasi)}}</td>
                                            <td style="color: red;">{{$itemC->updated_at ? $itemC->updated_at->format('d-m-Y') : '-'}}</td>
                                            <td style="text-align: center">
                                                @if ((int)$itemC->progress > 0 && $itemC->progress < 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$itemC->progress}}% ({{'Sedang Dikerjakan'}})</a>
                                                    @elseif ((int)$itemC->progress == 100)
                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$itemC->progress}}% ({{'Sudah Selesai'}})</a>
                                                    @else
                                                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{0}}% ({{'Belum Mulai'}})</a>
                                                    @endif
                                            </td>
                                            <td style="text-align: center">{{(strtotime($itemC->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</td>
                                            <td style="text-align: center">
                                                @if ((int)$itemC->progress >= 1 && $itemC->progress < 40) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-danger rounded btn-block">{{'Kritis'}}</a>
                                                    @elseif ((int)$itemC->progress >= 40 && $itemC->progress < 60) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-warning text-white rounded btn-block">{{'Terlambat'}}</a>
                                                        @elseif ((int)$itemC->progress >= 60 && $itemC->progress < 80) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Wajar'}}</a>
                                                            @elseif ((int)$itemC->progress >= 80 && $itemC->progress <= 100) <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Baik'}}</a>
                                                                @else
                                                                <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                                                                @endif
                                            </td>
                                            <td>{{$itemC->penyedia_jasa ?? '-'}}</td>
                                            <td>
                                                <a target="_blank" href="https://maps.google.com/maps?&z=13&mrt=yp&t=m&q={{ $itemA->latitude }}+{{ $itemA->longitude }}">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </a> 
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
{{-- <script src="{{ asset('admin') }}/plugins/chart.js/Chart.min.js"></script> --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    $(function() {
        $("#progress").DataTable({
            "responsive": true,
            "autoWidth": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "collapsed": true,
        });
        $("#progress_filter label").addClass('search');
        $("#progress-non-fisik").DataTable({
            "responsive": true,
            "autoWidth": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "collapsed": true,
        });
        $("#progress-non-fisik_filter label").addClass('search');
        $("#progress-kegiatan").DataTable({
            "responsive": true,
            "autoWidth": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "collapsed": true,
        });
        $("#progress-kegiatan_filter label").addClass('search');
        $("#progress-program").DataTable({
            "responsive": true,
            "autoWidth": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "collapsed": true,
        });
        $("#progress-program_filter label").addClass('search');
        $(".search input").before(`
					<span class="fa fa-search"></span>
			`);
        $(".search input").attr("placeholder", "Ketik Kata Kunci");

        //start display maps
        $(".search input").attr("style", "width: 20rem;");
        var map = L.map('mapDashboard').setView([-4.475296, 105.077107], 9);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        		attribution: '&copy;'
        }).addTo(map);
            // add point on maps
            var greenIcon = L.icon({
                iconUrl: "{{ asset('image/marker-kuning.png') }}",
                iconSize: [32, 32],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            var allPoints = [];
            @foreach ($detail_kegiatan as $item)
                var title = "<?= $item->title ?? '-' ?>";
                var noKontrak = "<?= $item->no_kontrak ?? '-' ?>";
                var jenisPengadaan = "<?= $item->jenis_pengadaan ?? '-' ?>";
                var nilaiKontrak = "<?= $item->nilai_kontrak ?? '-' ?>";
                var progress = "<?= $item->progress ?? '-' ?>";
                var awalKontrak = "<?= $item->awal_kontrak ?? '-' ?>";
                var akhirKontrak = "<?= $item->akhir_kontrak ?? '-' ?>";
                var penyediaJasa = "<?= $item->penyedia_jasa ?? '-' ?>";
                var noSpmk = "<?= $item->no_spmk ?? '-' ?>";

                var thisPoint = L.marker([<?= $item->latitude ?>, <?= $item->longitude ?>], {icon: greenIcon}).addTo(map)
                                .bindPopup("Data Informasi " + "<br>" + "<br>" + 
                                    "Nama Pekerjaan : " + title + "<br>" +
                                    "No Kontrak : " + noKontrak + "<br>" +
                                    "Jenis Pengadaan : " + jenisPengadaan + "<br>" +
                                    "Nilai Kontrak : " + nilaiKontrak + "<br>" +
                                    "Progress : " + progress + "<br>" +
                                    "Awal Kontrak : " + awalKontrak + "<br>" +
                                    "Akhir Kontrak : " + akhirKontrak + "<br>" +
                                    "Penyedia Jasa : " + penyediaJasa + "<br>" +
                                    "No SPMK : " + noSpmk + "<br>"
                                );
                allPoints.push([<?= $item->latitude ?>, <?= $item->longitude ?>]);
            @endforeach
            if (allPoints.length > 0) {
                var bounds = L.latLngBounds(allPoints); // Membuat batas dari semua koordinat
                map.fitBounds(bounds); // Menyesuaikan tampilan peta agar mencakup semua poin
            }
            // end add point on maps
        //end display maps 

        // Tambahkan layer peta dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        map.on("contextmenu", function(event) {
            console.log("user right-clicked on map coordinates: " + event.latlng.toString());
            L.marker(event.latlng).addTo(map);
        });
        let params = {
            "tahun": "{{request()->get('tahun')}}"
        };

        let query = Object.keys(params)
            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
            .join('&');
        fetch('/maps-data?' + query)
            .then(response => response.json())
            .then(pins => {
                console.log(pins);

                // Membuat ikon dengan warna merah
                var redIcon = L.icon({
                    iconUrl: "{{ asset('image/marker-merah.png') }}",
                    iconSize: [32, 32],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Membuat ikon dengan warna biru
                var blueIcon = L.icon({
                    iconUrl: "{{ asset('image/marker-biru.png') }}",
                    iconSize: [32, 32],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Membuat ikon dengan warna abu
                var grayIcon = L.icon({
                    iconUrl: "{{ asset('image/marker-abu.png') }}",
                    iconSize: [32, 32],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Membuat ikon dengan warna kuning
                var yellowIcon = L.icon({
                    iconUrl: "{{ asset('image/marker-kuning.png') }}",
                    iconSize: [32, 32],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Membuat ikon dengan warna hijau
                var greenIcon = L.icon({
                    iconUrl: "{{ asset('image/marker-hijau.png') }}",
                    iconSize: [32, 32],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                pins.forEach(function(pin) {
                    let icon = grayIcon;
                    if (pin.progress >= 1 && pin.progress < 40) {
                        icon = redIcon;
                    } else if (pin.progress >= 40 && pin.progress < 60) {
                        icon = yellowIcon;
                    } else if (pin.progress >= 60 && pin.progress < 80) {
                        icon = greenIcon;
                    } else if (pin.progress >= 80 && pin.progress <= 100) {
                        icon = blueIcon;
                    }
                    L.marker(pin.location, {
                            icon: icon
                        })
                        .addTo(map)
                        .bindPopup(pin.name);
                });
            })
    });
</script>
<script>
    // Ambil data dari endpoint menggunakan Ajax
    let params = {
        "tahun": "{{request()->get('tahun')}}"
    };

    let query = Object.keys(params)
        .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
        .join('&');

    fetch('/chart-data?' + query)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            let totalKeuangan = Array(12).fill(0); // Inisialisasi array untuk keuangan
            let totalFisik = Array(12).fill(0); // Inisialisasi array untuk fisik

            data.forEach(element => {
                totalKeuangan[element.bulan - 1] = element.total_keuangan;
                totalFisik[element.bulan - 1] = element.total_fisik;
            });

            console.log(totalKeuangan, totalFisik);

            // Chart Keuangan
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months, // Sumbu x adalah bulan
                    datasets: [{
                        label: 'Progres Keuangan',
                        data: totalKeuangan, // Sumbu y adalah total keuangan
                        backgroundColor: 'rgba(86, 146, 206, 0.2)',
                        borderColor: 'rgba(86, 146, 206, 1)',
                        borderWidth: 1
                    }, ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxFisik = document.getElementById('chartFisik').getContext('2d');
            var myChart = new Chart(ctxFisik, {
                type: 'line',
                data: {
                    labels: months, // Sumbu x adalah bulan
                    datasets: [{
                        label: 'Progres Fisik (%)',
                        data: totalFisik, // Sumbu y adalah total keuangan
                        backgroundColor: 'rgba(86, 146, 206, 0.2)',
                        borderColor: 'rgba(86, 146, 206, 1)',
                        borderWidth: 1
                    }, ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });

    function downloadExcel() {
        fetch('/chart-data')
            .then(response => response.json())
            .then(data => {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const result = [
                    ['Judul', 'Bulan', 'Daya Serap Kontrak', 'Keterangan'],
                ];
                data.forEach(element => {
                    result.push([element.daya_serap, convertMonth(element.month), element.total, element.keterangan])
                });
                console.log(result);
                const ws = XLSX.utils.aoa_to_sheet(result);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                XLSX.writeFile(wb, 'chart_data.xlsx');
            })
    }

    function downloadImage() {
        const imageLink = document.createElement('a');
        const canvas = document.getElementById('myChart');
        imageLink.download = 'chart_realisasi.png';
        imageLink.href = canvas.toDataURL('image/png', 1);
        imageLink.click();
    }

    function convertMonth(params) {
        switch (params) {
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;
            default:
                break;
        }
    }
</script>
@endsection
