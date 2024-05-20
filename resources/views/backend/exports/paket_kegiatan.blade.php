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
    </tr>
    </thead>
    <tbody>
        @foreach ($kegiatan as $itemC)
        <tr>
                <td>{{$itemC->title ?? '-'}}</td>
                <td  style="text-align: center">{{$itemC->bidang_name ?? '-'}}</td>
                <td style="text-align: center">{{$itemC->pptk_name ?? '-'}}</td>
                <td style="text-align: center">Rp.{{number_format($itemC->realisasi)}}</td>
                <td style="color: red;">{{$itemC->updated_at ? $itemC->updated_at->format('d-m-Y') : '-'}}</td>
                <td style="text-align: center">
                    @if ((int)$itemC->progress > 0 && $itemC->progress < 100)
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$itemC->progress}}% ({{'Sedang Dikerjakan'}})</a>
                    @elseif ((int)$itemC->progress == 100)
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$itemC->progress}}% ({{'Sudah Selesai'}})</a>
                    @else
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{0}}% ({{'Belum Mulai'}})</a>
                    @endif
                </td>
                <td style="text-align: center">{{(strtotime($itemC->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</td>
                <td style="text-align: center">
                    @if ((int)$itemC->progress >= 1 && $itemC->progress < 40)
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-danger rounded btn-block">{{'Kritis'}}</a>
                    @elseif ((int)$itemC->progress >= 40 && $itemC->progress < 60)
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-warning text-white rounded btn-block">{{'Terlambat'}}</a>
                    @elseif ((int)$itemC->progress >= 60 && $itemC->progress < 80)
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Wajar'}}</a>
                    @elseif ((int)$itemC->progress >= 80 && $itemC->progress <= 100)
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Baik'}}</a>
                    @else
                        <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemC->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                    @endif
                </td>
                <td>{{$itemC->penyedia_jasa ?? '-'}}</td>
        </tr>
        @endforeach
    </tbody>
</table>