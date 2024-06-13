<div class="tab-pane fade show {{ session('tab') == 'kurva_s' ? 'active' : '' }}" id="custom-content-below-kurva-s" role="tabpanel" aria-labelledby="custom-content-below-kurva-s-tab">
    <div class="row">
        <div class="col-md-6">
            <div class="container">
                <form action="{{ route('backend.detail_anggaran.update_kurva', ['detail_kegiatan_id' => $detail->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="p-2">Bulan</th>
                                <th class="p-2">Keuangan (%)</th>
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
                                    <input type="number" class="form-control form-control-sm" name="data[{{ $loop->index }}][keuangan]" value="{{ $dataKurvaS->keuangan }}">
                                </td>
                                <td class="p-2">
                                    <input type="number" class="form-control form-control-sm" name="data[{{ $loop->index }}][fisik]" value="{{ $dataKurvaS->fisik }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-left" style="margin-bottom: 2.25rem">
                        <button type="submit" class="btn btn-primary btn-sm text-white"><i class="fas fa-save mx-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-body">
                <div class="chart mt-5">
                    <canvas id="kurvaS" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>