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

    .bg-paket {
        background-color: #5792ce;
    }

    .total-paket {
        color: #5792ce;
    }
    @media (max-width: 575.98px) {
        #progress {
            display: none;
        }
        #progress_wrapper{
            display:none;
        }

        #card-progres{
            display: inherit !important;
        }
    }
</style>
@endsection
@section('main')
<form action="{{route('backend.dashboard.index')}}" method="GET">
    <div class="row justify-content-start">
        <div class="ml-3 col-4 col-lg-1 d-flex align-items-center">
            <label for="filter">Filter Tahun</label>
        </div>
        <div class="col-6 col-lg-3">
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
    <div class="col-lg-4 col-md-12">
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
    <div class="col-lg-4 col-md-12">
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
    <div class="col-lg-4 col-md-12">
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
    @can('lihat progres keuangan')
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h4 class="text-darkblue"><strong> Progres Keuangan {{request()->get('tahun') ? request()->get('tahun') : "2024"}}</strong></h4>
                </div>
                <div class="chart">
                    <canvas id="myChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endcan
    <div class="col-lg-6" id="section-chart-fisik">
        <div class="card">
            <div class="card-body">
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
<div class="row justify-content-center">
    <div class="col-md-3 col-sm-12">
        <div class="card row flex-row bg-paket justify-content-between align-items-center p-3">
            <div>
                <h5 class="text-center text-bold text-white">Total Paket</h5>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px">
                <span class="text-bold total-paket" style="font-size: 18px">{{$total_paket ?? 0}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card row flex-row bg-paket justify-content-between align-items-center p-3">
            <div>
                <h5 class="text-center text-bold text-white">Paket Belum Mulai</h5>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px">
                <span class="text-bold total-paket" style="font-size: 18px">{{$total_paket_belum_mulai ?? 0}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card row flex-row bg-paket justify-content-between align-items-center p-3">
            <div>
                <h5 class="text-center text-bold text-white">Paket Sedang <br>Dikerjakan</h5>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px">
                <span class="text-bold total-paket" style="font-size: 18px">{{$total_paket_dikerjakan ?? 0}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="card row flex-row bg-paket justify-content-between align-items-center p-3">
            <div>
                <h5 class="text-center text-bold text-white">Paket Selesai</h5>
            </div>
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px">
                <span class="text-bold total-paket" style="font-size: 18px">{{$total_paket_selesai ?? 0}}</span>
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
                <div class="row m-0 p-2">
                    <h4 class="text-darkblue"><strong> PROGRESS PEKERJAAN TAHUN {{request()->get('tahun') ? request()->get('tahun') : "2024"}}</strong></h4>
                    <div class="col p-0">
                        <div class="row m-0 overflow-auto">
                            <div class="col-12 px-0">
                                <table id="progress" class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="padding:1rem 2.25rem;">Nama Pekerjaan</th>
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

                                            @if ($itemA->progress->count() > 0)
                                            <td style="color: red;">{{$itemA->progress->first()->updated_at}}</td>
                                            @else
                                            <td style="color: red;">{{'-'}}</td>
                                            @endif
                                            @if (($itemA->progress[0]->nilai ?? 0 )>= 100)
                                            <td style="text-align: center"><a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$itemA->progress[0]->nilai ?? 0}}% ({{'Selesai'}})</a>
                                            </td>
                                            @elseif (($itemA->progress[0]->nilai ?? 0)>0)
                                            <td style="text-align: center"><a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$itemA->progress[0]->nilai ?? 0}}% ({{'Sedang Dikerjakan'}})</a>
                                            </td>
                                            @else
                                            <td style="text-align: center"><a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{$itemA->progress[0]->nilai ?? 0}}% ({{'Belum Mulai'}})</a>
                                            </td>
                                            @endif
                                            <td style="text-align: center">{{(strtotime($itemA->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</td>
                                            <td style="text-align: center">
                                                @if (($itemA->status_deviasi > 0 && $itemA->status_deviasi <= 10 )||$itemA->status_deviasi < 0 ) <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Aman'}}</a>
                                                        @elseif ($itemA->status_deviasi > 10)
                                                        <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-warning rounded btn-block">{{'Peringatan'}}</a>
                                                        @else
                                                        <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
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

                                @foreach ($fisik as $item)
                                <div id="card-progres" class="card mx-0 d-none">
                                    <div class="card-body p-0 p-1">
                                        <div class="row m-0 my-1 justify-content-between">
                                            <div class="col-5 d-flex align-items-center">
                                                <p class="text-darkblue" style="font-size: 14px; font-weight:bold; margin:0;">Nama Pekerjaan</p>
                                            </div>
                                            <div class="col-6 pl-0">
                                                <p style="font-size: 14px;" class="m-0">{{$item->title}}</p>
                                            </div>
                                        </div>
                                        <div class="row m-0 my-1 justify-content-between">
                                            <div class="col-5 d-flex align-items-center">
                                                <p class="text-darkblue" style="font-size: 14px; font-weight:bold; margin:0;">Bidang</p>
                                            </div>
                                            <div class="col-6 pl-0">
                                                <p style="font-size: 14px;" class="m-0">{{$item->bidang_name}}</p>
                                            </div>
                                        </div>
                                        <div class="row m-0 my-1 justify-content-between">
                                            <div class="col-5 d-flex align-items-center">
                                                <p class="text-darkblue" style="font-size: 14px; font-weight:bold; margin:0;">Realisasi</p>
                                            </div>
                                            <div class="col-6 pl-0">
                                                <p style="font-size: 14px;" class="m-0">Rp.{{number_format($item->realisasi)}}</p>
                                            </div>
                                        </div>
                                        <div class="row m-0 my-1 justify-content-between">
                                            <div class="col-5 d-flex align-items-center">
                                                <p class="text-darkblue" style="font-size: 14px; font-weight:bold; margin:0;">Progress</p>
                                            </div>
                                            <div class="col-6 pl-0">
                                            @if (($item->progress[0]->nilai ?? 0 )>= 100)
                                            <td style="text-align: center"><a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $item->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$item->progress[0]->nilai ?? 0}}% ({{'Selesai'}})</a>
                                            </td>
                                            @elseif (($item->progress[0]->nilai ?? 0)>0)
                                            <td style="text-align: center"><a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $item->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$item->progress[0]->nilai ?? 0}}% ({{'Sedang Dikerjakan'}})</a>
                                            </td>
                                            @else
                                            <td style="text-align: center"><a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $item->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{$item->progress[0]->nilai ?? 0}}% ({{'Belum Mulai'}})</a>
                                            </td>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="row m-0 my-1 justify-content-between">
                                            <div class="col-5 d-flex align-items-center">
                                                <p class="text-darkblue" style="font-size: 14px; font-weight:bold; margin:0;">Lokasi</p>
                                            </div>
                                            <div class="col-6 pl-0">
                                            <a target="_blank" href="https://maps.google.com/maps?&z=13&mrt=yp&t=m&q={{ $item->latitude }}+{{ $item->longitude }}">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
        @foreach($detail_kegiatan as $item)
        var title = "<?= $item->title ?? '-' ?>";
        var noKontrak = "<?= $item->no_kontrak ?? '-' ?>";
        var jenisPengadaan = "<?= $item->jenis_pengadaan ?? '-' ?>";
        var nilaiKontrak = "<?= $item->nilai_kontrak ?? '-' ?>";
        var progress = "<?= $item->progress ?? '-' ?>";
        var awalKontrak = "<?= $item->awal_kontrak ?? '-' ?>";
        var akhirKontrak = "<?= $item->akhir_kontrak ?? '-' ?>";
        var penyediaJasa = "<?= $item->penyedia_jasa ?? '-' ?>";
        var noSpmk = "<?= $item->no_spmk ?? '-' ?>";

        var thisPoint = L.marker([<?= $item->latitude ?>, <?= $item->longitude ?>], {
                icon: greenIcon
            }).addTo(map)
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
            @can('lihat progres keuangan')

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
            @endcan

            @if(Auth::user()->cannot('lihat progres keuangan'))
            $('#section-chart-fisik').removeClass('col-lg-6');
            $('#section-chart-fisik').addClass('col-lg-12');
            @endif
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
