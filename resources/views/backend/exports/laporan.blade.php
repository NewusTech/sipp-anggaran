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
    <div class="col mt-3">
        <table class="table table-bordered alzgn-middle">
            <tr>
                <th colspan="12" style="text-align:center; font-weight: bold;">DAFTAR KEGIATAN DINAS PUPR {{ $bidang_id ? $bidang[0]->name : "KABUPATEN TULANG BAWANG BARAT" }} T.A {{ $bidang ? $bidang[0]->kegiatan[0]->tahun : "" }}</th>
            </tr>
            <thead class="text-bold">
                <tr>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">No</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">No Kontrak</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Nama Pekerjaan</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Perusahaan</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Tgl Kontrak</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Nilai Kontrak</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Nomor SPMK</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Tanggal Akhir Kontrak</td>
                    <td rowspan="2" style="font-weight: bold; text-align: center;">Progress</td>
                </tr>
                <tr></tr>
            </thead>
            <tbody>
                @php
                    $index=1;
                @endphp
                @if ($bidang->count() > 0)
                @foreach ($bidang as $item)
                    @foreach ($item->kegiatan as $kegiatan)
                    <tr class="bg-secondary">
                        <td>{{$index}}</td>
                        <td colspan="11">{{$kegiatan->title}}</td>
                    </tr>
                    @php
                        $index++;
                    @endphp
                    @if ( count($kegiatan->detail) > 0)
                        @foreach ($kegiatan->detail as $detail)
                            <tr>
                                <td></td>
                                <td>{{ $detail->no_kontrak }}</td>
                                <td>{{ $detail->title }}</td>
                                <td>{{ $detail->penyedia_jasa }}</td>
                                <td>{{ \Carbon\Carbon::parse($detail->awal_kontrak )->format('d-m-Y') }}</td>
                                <td>{{ 'Rp.'. number_format($detail->nilai_kontrak) }}</td>
                                <td>{{ $detail->no_spmk }}</td>
                                <td>{{ \Carbon\Carbon::parse($detail->akhir_kontrak )->format('d-m-Y') }}</td>
                                <td>{{ $detail->progress }}%</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td></td>
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
