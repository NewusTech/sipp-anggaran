@extends('layouts.main')

@section('title', 'Detail Anggaran')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <style>
        .leaflet-container {
            height: 310px;
            max-width: 100%;
            border-radius: 15px;
        }

        /*files*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 3px solid transparent;
            box-shadow: 0 0 4px #ccc;
            outline: 0;
            margin: 4px;
            border-radius: 12px;
        }

        .image-checkbox-checked {
            border-color: #2196f3;
        }

        img {
            border-radius: 8px;
            max-height: 160px !important;
            max-width: -webkit-fill-available;
        }

        .image-checkbox i {
            display: none;
            color: #2196f3;
        }

        .image-checkbox-checked {
            position: relative;
        }

        .image-checkbox-checked i {
            display: block;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>

{{--    <link rel="stylesheet" href="{{ asset('css/select_file.css') }}">--}}
@endsection

@section('breadcump')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Detail Anggaran') }}</li>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h4 class="text-darkblue"><a href="{{route('backend.kegiatan.index')}}" class="btn btn-default rounded"><i class="fas fa-arrow-left"></i></a><strong> HONORARIUM PPTK </strong></h4>
                    </div>
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-detail-tab" data-toggle="pill" href="#custom-content-above-detail" role="tab" aria-controls="custom-content-below-detail" aria-selected="true">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-penanggung_jawab-tab" data-toggle="pill" href="#custom-content-above-penanggung_jawab" role="tab" aria-controls="custom-content-below-penanggung_jawab" aria-selected="true">Penanggung Jawab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-anggaran-tab" data-toggle="pill" href="#custom-content-above-anggaran" role="tab" aria-controls="custom-content-below-anggaran" aria-selected="true">Anggaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-dokumentasi-tab" data-toggle="pill" href="#custom-content-above-dokumentasi" role="tab" aria-controls="custom-content-below-dokumentasi" aria-selected="true">Dokumentasi</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        @include('backend.kegiatan._detail')
                        @include('backend.kegiatan._penanggung_jawab')
                        @include('backend.kegiatan._anggaran')
                        @include('backend.kegiatan._dokumentasi')
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
    <!-- ChartJS -->
    <script src="{{ asset('admin') }}/plugins/chart.js/Chart.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

{{--    <script src="{{ asset('js/select_files.js') }}"></script>--}}

    <script>
        $(function () {
            $("#table_anggran").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "collapsed": true,
            });
            $("#table_anggran_filter").append('@can("tambah anggaran")<button id="addAnggaran" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create-anggaran"><i class="fas fa-plus"></i></button>@endcan');
            $("#table_anggran_filter").addClass('btn-action-right');
            $("#table_anggran_filter label").addClass('search');
            $(".search input").before(`<span class="fa fa-search"></span>`);
            $(".search input").attr("placeholder", "Ketik Kata Kunci");
            $(".search input").attr("style", "width: 13rem;");

            // $("#table_anggran_2").DataTable({
            //     "responsive": true,
            //     "autoWidth": false,
            //     "paging": false,
            //     "lengthChange": false,
            //     "searching": false,
            //     "ordering": false,
            //     "collapsed": true,
            // });

            $("#table_dokumentasi").DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "collapsed": true,
            });
            if ($("#table_dokumentasi_filter").length) {
                // $("#table_dokumentasi_filter").append('<button id="addDokumentasi" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create-dokumentasi"><i class="fas fa-plus"></i> Tambah Data</button>');
                // $("#table_dokumentasi_filter").addClass('btn-action-right');
                $("#table_dokumentasi_filter label").addClass('search');
                $(".search input").before(`<span class="fa fa-search"></span>`);
                $(".search input").attr("placeholder", "Ketik Kata Kunci");
                $(".search input").attr("style", "width: 13rem;");
            }



            // //const map = L.map('map').setView([-5.373931174208121, 105.24278249089507], 13);
            // const map = L.map('map', {
            //     center: ['{{$detail->latitude}}', '{{$detail->longitude}}'],
            //     zoom: 13
            // })

            // // const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            // //     maxZoom: 19,
            // //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            // // }).addTo(map);

            // L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

            // L.marker(['{{$detail->latitude}}', '{{$detail->longitude}}']).addTo(map);
            var map = L.map('map').setView(['{{$detail->latitude}}', '{{$detail->longitude}}'], 13);
            setTimeout(function(){ map.invalidateSize(true)}, 1000);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker(['{{$detail->latitude}}', '{{$detail->longitude}}']).addTo(map)


            //load data chart
            $('#custom-content-below-grafik-tab').on('click', function() {
                console.log('load data nih');

                $.ajax({
                    url: "{{ route('backend.data_anggaran.index', ['type' => 'realisasi']) }}",
                    type: "get",
                    data: {

                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                        console.log(xhr);
                    }
                });

                $.ajax({
                    url: "{{ route('backend.data_anggaran.index', ['type' => 'schedule']) }}",
                    type: "get",
                    data: {

                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                        console.log(xhr);
                    }
                });

                $.ajax({
                    url: "{{ route('backend.data_anggaran.index', ['type' => 'keuangan']) }}",
                    type: "get",
                    data: {

                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                        console.log(xhr);
                    }
                });

            });


            var areaChartData = {
                labels  : ['31 Mar 2020', '30 Apr 2020', '29 Mei 2020', '30 Jun 2020', '30 Jul 2020', '31 Aug 2020', '30 Sep 2020'],
                datasets: [
                    {
                        label               : 'Realisasi',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.9)',
                        pointRadius          : true,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [0, 10, 20, 30, 40, 100, 60]
                    },
                    {
                        label               : 'Target',
                        backgroundColor     : 'rgb(184,4,4)',
                        borderColor         : 'rgb(239,0,0)',
                        pointRadius         : true,
                        pointColor          : 'rgb(239,0,0)',
                        pointStrokeColor    : '#ef0000',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgb(239,0,0)',
                        data                : [10, 10, 20, 30, 11, 20, 60]
                    },
                ]
            }

            var areaChartOptions = {
                maintainAspectRatio : true,
                responsive : true,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 30,
                        fontsize: 10
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines : {
                            display : false,
                        }
                    }],
                    yAxes: [{
                        gridLines : {
                            display : true,
                        },
                        scaleLabel : {
                            labelString : 'Progress (%)',
                            display : true,
                        }
                    }]
                }
            }

            var areaChartPaguOptions = {
                maintainAspectRatio : true,
                responsive : true,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 30,
                        fontsize: 10
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines : {
                            display : false,
                        }
                    }],
                    yAxes: [{
                        gridLines : {
                            display : true,
                        },
                        scaleLabel : {
                            labelString : 'Pagu (Rp.)',
                            display : true,
                        }
                    }]
                }
            }

            //-------------
            //- LINE CHART -
            //--------------
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;
            lineChartOptions.datasetFill = false

            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })

            var lineChartScheduleCnvs = $('#lineChartSchedule').get(0).getContext('2d')
            var lineChartScheduleOptions = $.extend(true, {}, areaChartOptions)
            var lineChartScheduleData = $.extend(true, {}, areaChartData)
            lineChartScheduleData.datasets[0].fill = false;
            lineChartScheduleData.datasets[1].fill = false;
            lineChartScheduleOptions.datasetFill = false

            var lineChartSchedule = new Chart(lineChartScheduleCnvs, {
                type: 'line',
                data: lineChartScheduleData,
                options: lineChartScheduleOptions
            })


            var areaChartData = {
                labels  : ['31 Mar 2020', '30 Apr 2020', '29 Mei 2020', '30 Jun 2020', '30 Jul 2020', '31 Aug 2020', '30 Sep 2020'],
                datasets: [
                    {
                        label               : 'Realisasi',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.9)',
                        pointRadius          : true,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [1000000, 5000000, 1000000, 3000000, 6000000, 1000000, 2000000]
                    },
                    {
                        label               : 'Target',
                        backgroundColor     : 'rgb(184,4,4)',
                        borderColor         : 'rgb(239,0,0)',
                        pointRadius         : true,
                        pointColor          : 'rgb(239,0,0)',
                        pointStrokeColor    : '#ef0000',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgb(239,0,0)',
                        data                : [1000000, 2000000, 3000000, 2500000, 3500000, 5000000, 4000000]
                    },
                ]
            }

            var lineChartKeuangan = $('#lineKeuanganChart').get(0).getContext('2d')
            var lineChartKeuanganOptions = $.extend(true, {}, areaChartPaguOptions)
            var lineChartKeuanganData = $.extend(true, {}, areaChartData)
            lineChartKeuanganData.datasets[0].fill = false;
            lineChartKeuanganData.datasets[1].fill = false;
            lineChartKeuanganOptions.datasetFill = false

            var lineChartKeuangan = new Chart(lineChartKeuangan, {
                type: 'line',
                data: lineChartKeuanganData,
                options: lineChartKeuanganOptions
            })

        });

        function downloadChart(type) {
            const imageLink = document.createElement('a');

            if(type === 'realisasi') {
                const canvas = document.getElementById('lineChart');
                imageLink.download = 'chart_realisasi.png';
                imageLink.href = canvas.toDataURL('image/png', 1);
            } else if (type === 'schedule') {
                const canvas = document.getElementById('lineChartSchedule');
                imageLink.download = 'chart_schedule.png';
                imageLink.href = canvas.toDataURL('image/png', 1);
            } else if (type === 'keuangan') {
                const canvas = document.getElementById('lineKeuanganChart');
                imageLink.download = 'chart_keuangan.png';
                imageLink.href = canvas.toDataURL('image/png', 1);
            }

            imageLink.click();
        }

        //files
        jQuery(function ($) {
            var mediaArray = [];
            var selectedMediasId;
            var isMultipleAllowed = true;
            $('#allowmultiple').click(function () {
                isMultipleAllowed = $('#allowmultiple').is(':checked') ? true : false;
                $('.image-checkbox-checked').each(function () {
                    $(this).removeClass('image-checkbox-checked');
                });
                mediaArray = [];
                $('#selectedmediapreview').html('');
            });

            $(".image-checkbox").on("click", function (e) {
                var selected = $(this).find('img').attr('data-path');
                //console.log(selected);
                if ($(this).hasClass('image-checkbox-checked')) {
                    $(this).removeClass('image-checkbox-checked');
                    // remove deselected item from array
                    mediaArray = $.grep(mediaArray, function (value) {
                        return value != selected;
                    });
                }
                else {
                    if (isMultipleAllowed == false) {
                        $('.image-checkbox-checked').each(function () {
                            $(this).removeClass('image-checkbox-checked');
                        });
                        mediaArray = [];
                        mediaArray.push(selected);
                    } else {
                        if (mediaArray.indexOf(selected) === -1) {
                            mediaArray.push(selected);
                        }
                    }
                    $(this).addClass('image-checkbox-checked');
                }
                //console.log(selected);
                //console.log(mediaArray);
                selectedMediasId = mediaArray.join(",");
                //console.log(selectedMediasId);
                $('#selectedmediapreview').html('<div class="alert alert-success"><pre lang="js">' + JSON.stringify(mediaArray.join(", "), null, 4) + '</pre></div>');
                //console.log(isMultipleAllowed);
                e.preventDefault();
            });

            $('.show-file').on('click', function() {
                mediaArray = [];
                $('.check-all-'+$(this).data('id')).removeClass('image-checkbox-checked');
                $('.row-file').hide();
                $('.file-preview-'+$(this).data('id')).show();
                var elems = $('.files-list-'+$(this).data('id'));

                $('.check-all-'+$(this).data('id')).addClass('image-checkbox-checked');

                for (var i=elems.length; i--;) mediaArray.push(elems[i].dataset.path);

            });

            $('#downloadFiles').on('click', function(e) {

                if(mediaArray.length == 0) {
                    alert('Pilih file terlebih dahulu');
                }

                e.preventDefault();

                var temporaryDownloadLink = document.createElement("a");
                temporaryDownloadLink.style.display = 'none';

                document.body.appendChild(temporaryDownloadLink);

                for( var n = 0; n < mediaArray.length; n++ )
                {
                    var download = mediaArray[n];
                    temporaryDownloadLink.setAttribute( 'href', download);
                    temporaryDownloadLink.setAttribute( 'download', download.split('/').pop());

                    temporaryDownloadLink.click();
                }

                document.body.removeChild( temporaryDownloadLink );
            });
        });
    </script>
@endsection

