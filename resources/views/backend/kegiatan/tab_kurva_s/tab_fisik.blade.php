<div class="tab-pane fade show {{session('tab') == '' || $tab == 'kurva_s' ? 'active' : ''}}" id="custom-content-above-fisik" role="tabpanel" aria-labelledby="custom-content-below-fisik-tab">
    <div class="row">
        <div class="col-md-6">
            <h4>Rencana Kegiatan Fisik</h4>
            <div class="container">
                <form action="{{ route('backend.detail_anggaran.update_kurva', ['detail_kegiatan_id' => $detail->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div style="max-height: 267px; height: 267x; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="p-2">Bulan</th>
                                    <th class="p-2">Minggu-Ke</th>
                                    <!-- <th class="p-2">Keuangan (%)</th> -->
                                    <th class="p-2">Fisik (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kurvaS as $dataKurvaS)
                                <tr class="p-2">
                                    <td class="p-2">
                                        {{ \Carbon\Carbon::parse($dataKurvaS->bulan)->locale('id')->isoFormat('MMMM') }}
                                        <input type="hidden" name="data[{{ $loop->index }}][bulan]" value="{{ $dataKurvaS->bulan }}">
                                    </td>
                                    <td class="p-2">
                                        {{ $dataKurvaS->minggu }}
                                        <input type="hidden" name="data[{{ $loop->index }}][minggu]" value="{{ $dataKurvaS->minggu }}">
                                    </td>
                                    <td class="p-2">
                                        @can('ubah kurva')
                                        <input id="inputKurva" type="text" class="form-control form-control-sm" name="data[{{ $loop->index }}][fisik]" value="{{ $dataKurvaS->fisik }}" pattern="^[0-9]*\.?[0-9]+$" title="Hanya angka dan titik desimal yang diizinkan">
                                        @else
                                        <input type="number" class="form-control form-control-sm" value="{{ $dataKurvaS->fisik }}" disabled>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-left" style="margin-bottom: 2.25rem">
                        @can('ubah kurva')
                        <button type="submit" class="btn btn-primary btn-sm text-white"><i class="fas fa-save mx-2"></i>Simpan</button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
        <!-- Progress Fisik -->
        <div class="col-md-6">
            <h4>Realisasi Fisik</h4>
            <div class="container">
                <form action="{{ route('backend.detail_anggaran.tambah_progres', ['detail_kegiatan_id' => $detail->id]) }}" method="POST">
                    <div style="max-height: 250px; height: 250px; overflow-y: auto;">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="p-2">Bulan</th>
                                    <th class="p-2">Minggu-ke</th>
                                    <th class="p-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @csrf
                                @foreach ($kurvaS as $rencana)
                                @php
                                    $bulanRencana =\Carbon\Carbon::parse($rencana->bulan)->format('m');
                                    $nilai = $progresFisik->where('bulan', $bulanRencana)->where('minggu', $rencana->minggu)->first()->nilai ?? 0;
                                @endphp
                                <input type="hidden" name="jenis_progres" value="fisik">
                                <tr class="p-2">
                                    <td class="p-2">
                                        {{ \Carbon\Carbon::parse($rencana->bulan)->locale('id')->isoFormat('MMMM') }} <!-- Ganti $item->bulan dengan $rencana->bulan -->
                                        <input type="hidden" name="data[{{ $loop->index }}][bulan]" value="{{ $rencana->bulan }}">
                                    </td>
                                    <td class="p-2">
                                        {{ $rencana->minggu }} <!-- Ganti $item->minggu dengan $rencana->minggu -->
                                        <input type="hidden" name="data[{{ $loop->index }}][minggu]" value="{{ $rencana->minggu }}">
                                    </td>
                                    <td class="p-2">
                                        @can('ubah kurva')
                                        <input id="inputKurva" type="text" class="form-control form-control-sm" name="data[{{ $loop->index }}][nilai]" value="{{ $nilai }}" pattern="^[0-9]*\.?[0-9]+$" title="Hanya angka dan titik desimal yang diizinkan">
                                        @else
                                        <span>{{ $nilai }}</span>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @can('update progres')
                    <div class="text-left mt-3" style="margin-bottom: 2.25rem">
                        <button type="submit" class="btn btn-primary btn-sm text-white"><i class="fas fa-save mx-2"></i>Simpan</button>
                    </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-body">
                <div class="chart">
                    <canvas id="kurvaS" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
