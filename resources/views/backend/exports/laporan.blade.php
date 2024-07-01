<style>
    .text-bold,
    .text-bold.table td,
    .text-bold.table th {
        font-weight: 700;
    }

    .text-center {
        text-align: center !important;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }
</style>
<div class="table-responsive p-0 text-center">
    <div class="col text-center">
        <h4><strong>RELASI LAPORAN KEGIATAN DINAS PUPR</strong></h4>
        <h4><strong>KABUPATEN TULANG BAWANG BARAT </strong></h4>
    </div>
    <div class="col mt-3">
        <table class="table table-bordered alzgn-middle">
            <thead class="text-bold">
                <tr>
                    <td rowspan="2">No</td>
                    <td rowspan="2">Tahun / Kontrak</td>
                    <td rowspan="2">Kegiatan/Sub Kegiatan</td>
                    <td rowspan="2">Paket</td>
                    <td rowspan="2">Pagu</td>
                    <td colspan="2">Realisasi</td>
                    <td rowspan="2">Sisa</td>
                </tr>
                <tr>
                    <td>Fisik</td>
                    <td>Keuangan</td>
                </tr>
            </thead>
            <tbody>
                @if ($bidang->count() > 0)
                @foreach ($bidang as $item)
                @foreach ($item->kegiatan as $kegiatan)
                <tr class="bg-secondary">
                    <td>{{$loop->iteration}}</td>
                    <td>{{\Carbon\Carbon::parse($kegiatan->created_at)->format('Y')}}</td>
                    <td>{{$kegiatan->title}}</td>
                    <td>{{$kegiatan->jenis_paket}}</td>
                    <td>Rp.{{number_format($kegiatan->alokasi)}}</td>
                    <td></td>
                    <td></td>
                    <td>Rp.{{ number_format($kegiatan->sisa)}}</td>
                </tr>
                @foreach ($kegiatan->detail as $detail)
                <tr>
                    <td></td>
                    <td>{{\Carbon\Carbon::parse($detail->awal_kontrak )->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($detail->akhir_kontrak)->format('d-m-Y')}}</td>
                    <td>{{$detail->title}}</td>
                    <td>Fisik</td>
                    <td>Rp.{{number_format((int)$detail->pagu)}}</td>
                    <td>
                        @if ($detail->progres->count()>0 )
                        {{$detail->progres->where('jenis_progres','fisik')->sum('nilai')}}%
                        @else
                        {{'Data Kosong'}}
                        @endif
                    </td>
                    <td>
                        @if ($detail->progres->count()>0)
                        {{'Rp.'. number_format($detail->progres->where('jenis_progres','keuangan')->sum('nilai'))}}
                        @else
                        {{'-'}}
                        @endif
                    </td>
                    <td>
                        @if ($detail->progres->count()>0)
                        {{'Rp.'. number_format((int)$detail->pagu - $detail->progres->where('jenis_progres','keuangan')->sum('nilai'))}}
                        @else
                        {{'-'}}
                        @endif
                    </td>
                </tr>
                @endforeach
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
