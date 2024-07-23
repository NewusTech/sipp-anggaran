@foreach ($subKegiatan->detail as $detail)
<tr>
    <td class="table-success"></td>
    <td class="table-info"></td>
    <td class="text-center ">{{$detail->title}}</td>
    @php
    $pagu_anggaran = str_replace(',', '', $detail->pagu);
    @endphp
    <td class="text-center">Rp.{{ number_format($pagu_anggaran)}}</td>
    <td class="text-center">Rp.{{number_format($detail->nilai_kontrak)}}</td>
    @if ($detail->progres->count() > 0)
        <td class="text-center">{{$detail->progres->last()->nilai}}%</td>
    @else
        <td class="text-center">{{0}}%</td>
    @endif
    <td class="text-center">
        <form action="{{ route('backend.detail_kegiatan.verifikasi', $detail->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-check">
                @can('verifikasi admin')
                <input type="hidden" name="verifikasi_admin" value="false">
                <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="blankCheckbox" name="verifikasi_admin" value="{{ $detail->verifikasi_admin == 'true' ? 'false' : 'true' }}" {{ $detail->verifikasi_admin == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
                @else
                <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="blankCheckbox" {{ $detail->verifikasi_admin == 'true' ? 'checked' : '' }} disabled>
                @endcan
            </div>
        </form>
    </td>
    <td class="text-center">
        <div class="form-floating" data-toggle="modal" data-target="#modal-lg-komentar-admin-{{$detail->id}}">
            @can('komentar admin')
            <textarea class="form-control" placeholder="Komentar" id="komentarAdmin" name="komentar_admin">{{ $detail->komentar_admin}}</textarea>
            @else
            <textarea class="form-control" placeholder="Komentar" disabled>{{ $detail->komentar_admin}}</textarea>
            @endcan
        </div>
        @include('backend.kegiatan._modal_komentar', ['param'=>'admin'])
    </td>
    <td class="text-center">
        <div class="form-check">
            <form action="{{ route('backend.detail_kegiatan.verifikasi', $detail->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-check">
                    @can('verifikasi pengawas')
                    <input type="hidden" name="verifikasi_pengawas" value="false"> <!-- Memastikan ketika unchecked checkbox nilainya tetap di kirim -->
                    <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="verifikasiPengawas" name="verifikasi_pengawas" value="{{ $detail->verifikasi_pengawas == 'true' ? 'false' : 'true' }}" {{ $detail->verifikasi_pengawas == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
                    @else
                    <input class="form-check-input position-static" type="checkbox" style="width: 20px; height: 20px;" id="blankCheckbox" {{ $detail->verifikasi_pengawas == 'true' ? 'checked' : '' }} disabled>
                    @endcan
                </div>
            </form>
        </div>
    </td>
    <!-- Komentar -->
    <td class="text-center">
        <div class="form-floating" data-toggle="modal" data-target="#modal-lg-komentar-pengawas-{{$detail->id}}">
            @can('komentar pengawas')
            <textarea class="form-control" placeholder="Komentar" id="komentarPengawas" name="komentar_pengawas">{{ $detail->komentar_pengawas}}</textarea>
            @else
            <textarea class="form-control" placeholder="Komentar" disabled>{{ $detail->komentar_pengawas}}</textarea>
            @endcan
        </div>
        @include('backend.kegiatan._modal_komentar', ['param'=>'pengawas'])
    </td>
    <td>
        <div class="d-flex">
            @can('lihat detail kegiatan')
            <a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail->id]) }}" class=" btn btn-sm btn-secondary "><i class="fas fa-eye"></i></a>
            @endcan
            @can('hapus detail kegiatan')
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-lg-detail-delete-{{$detail->id}}"><i class="fas fa-trash"></i></button>
            @endcan
            @can('ubah detail kegiatan')
            <button type="button" style="color: white;" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-lg-edit-detail-{{$detail->id}}"><i class="fas fa-edit"></i></button>
            @endcan
        </div>
    </td>
</tr>
@include('backend.kegiatan._modal_delete_detail')
@include('backend.kegiatan._modal_edit_detail')
@endforeach
