<div class="tab-pane fade show" id="custom-content-above-grafik" role="tabpanel" aria-labelledby="custom-content-below-grafik-tab">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-bold text-darkblue text-wrap text-sm">
                    GRAFIK PROGRESS REALISASI {{ $detail->kegiatan->tahun ?? '-' }}
                </div>
                <div class="card-action-right mt-1">
                   <a href="{{ route('backend.data_anggaran.progress', ['type' => 'Progres Realisasi']) }}" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</a>
                    {{-- <button onclick="downloadChart('realisasi')" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</button> --}}
                </div>
                <div class="card-body">
                    <div class="chart mt-5">
                        <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-bold text-darkblue text-wrap text-sm">
                    GRAFIK TIME SCHEDULE {{ $detail->kegiatan->tahun ?? '-' }}
                </div>
                <div class="card-action-right mt-1">
                   <a href="{{ route('backend.data_anggaran.progress', ['type' => 'Time Schedule']) }}" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</a>
                    {{-- <button onclick="downloadChart('schedule')" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</button> --}}
                </div>
                <div class="card-body">
                    <div class="chart mt-5">
                        <canvas id="lineChartSchedule" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-bold text-darkblue text-wrap text-sm">
                    GRAFIK KEUANGAN {{ $detail->kegiatan->tahun ?? '-' }}
                </div>
                <div class="card-action-right mt-1">
{{--                    <a href="{{ route('backend.data_anggaran.anggaran') }}" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</a>--}}
                    <button onclick="downloadChart('keuangan')" class="btn btn-primary btn-sm rounded"><i class="fas fa-download"></i> Download</button>
                </div>
                <div class="card-body">
                    <div class="chart mt-5">
                        <canvas id="lineKeuanganChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
