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
    </tr>
    </thead>
    <tbody>
    @foreach ($fisik as $itemA)
    <tr>
            <td>{{$itemA->title ?? '-'}}</td>
            <td  style="text-align: center">{{$itemA->bidang_name ?? '-'}}</td>
            <td style="text-align: center">{{$itemA->pptk_name ?? '-'}}</td>
            <td style="text-align: center">Rp.{{number_format($itemA->realisasi)}}</td>
            <td style="color: red;">{{$itemA->updated_at ? $itemA->updated_at->format('d-m-Y') : '-'}}</td>
            <td style="text-align: center">
                @if ((int)$itemA->progress > 0 && $itemA->progress < 100)
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{$itemA->progress}}% ({{'Sedang Dikerjakan'}})</a>
                @elseif ((int)$itemA->progress == 100)
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{$itemA->progress}}% ({{'Sudah Selesai'}})</a>
                @else
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{0}}% ({{'Belum Mulai'}})</a>
                @endif
            </td>
            <td style="text-align: center">{{(strtotime($itemA->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</td>
            <td style="text-align: center">
                @if ((int)$itemA->progress >= 1 && $itemA->progress < 40)
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-danger rounded btn-block">{{'Kritis'}}</a>
                @elseif ((int)$itemA->progress >= 40 && $itemA->progress < 60)
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-warning text-white rounded btn-block">{{'Terlambat'}}</a>
                @elseif ((int)$itemA->progress >= 60 && $itemA->progress < 80)
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-success rounded btn-block">{{'Wajar'}}</a>
                @elseif ((int)$itemA->progress >= 80 && $itemA->progress <= 100)
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-primary rounded btn-block">{{'Baik'}}</a>
                @else
                    <a href="{{ route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $itemA->detail_kegiatan_id]) }}" class="btn btn-sm btn-default rounded btn-block">{{'Belum Mulai'}}</a>
                @endif
            </td>
            <td>{{$itemA->penyedia_jasa ?? '-'}}</td>
    </tr>
    @endforeach
    </tbody>
</table>