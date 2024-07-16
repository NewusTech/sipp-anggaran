@forelse ($item->kegiatan as $kegiatan)
<div class="accordion" id="accordionKegiatan">
    <div class="card shadow-none bg-dropdown m-0 border">
        <div class="card-header px-2 py-4" id="headingTwo">
            <div class="row m-0 justify-content-between collapsed" data-toggle="collapse" data-target="#collapse-{{$kegiatan->id}}" aria-expanded="false" aria-controls="collapse">
                <div class="col-8">
                    <strong>{{$kegiatan->title}}</strong>
                </div>
                <div class="col-4 d-flex justify-content-between align-items-center">
                    <strong>Total: {{$kegiatan->detail_kegiatan->count()}}</strong>
                    <img src="{{asset('image/chevron-down.svg')}}" style="width: 25px; height: 25px;" alt="">
                </div>
            </div>
        </div>
        <div id="collapse-{{$kegiatan->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionKegiatan">
            <div class="card-body py-2 px-0">
                <!-- Dropdown Pekerjaan -->
                @forelse ($kegiatan->detail_kegiatan as $detail)
                <div class="accordion my-1 mx-1" id="accordionPekerjaan">
                    <div class="card shadow-none border m-0">
                        <div class="card-header px-2 py-4" id="headingTwo">
                            <div class="row m-0 justify-content-between" data-toggle="collapse" data-target="#collapse-{{$detail->id}}" aria-expanded="false" aria-controls="collapse">
                                <div class="col-2 d-flex justify-content-end align-items-center">
                                    <img src="{{asset('image/chevron-down.svg')}}" style="width: 25px; height: 25px;" alt="">
                                </div>
                                <div class="col-10">
                                    <strong>{{$detail->title}}</strong>
                                </div>
                            </div>
                        </div>
                        <div id="collapse-{{$detail->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionPekerjaan">
                            <div class="card-body">
                                <div class="row flex-column m-0 mb-1">
                                    <strong>Kode Pekerjaan</strong>
                                    <div>{{$detail->no_detail_kegiatan}}</div>
                                </div>
                                <div class="row flex-column m-0 mb-1">
                                    <strong>Jenis Pekerjaan</strong>
                                    <div>Fisik</div>
                                </div>
                                <div class="row flex-column m-0 mb-1">
                                    <strong>Alokasi</strong>
                                    <div class="row m-0 justify-content-between">
                                        <div class="col-6 pl-0 pr-2">
                                            <div>Realisasi Pekerjaan</div>
                                            <div>Pagu / Nilai Kontrak</div>
                                        </div>
                                        <div class="col-6 p-0">
                                            <div>Rp.{{number_format($detail->alokasi)}}</div>
                                            <div>Rp.{{number_format($detail->nilai_kontrak)}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row flex-column m-0 mb-1">
                                    <strong>Aksi</strong>
                                    <div class="row">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center">Tidak ada data</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@empty
<div id="accordionKegiatan" class="text-center">Tidak ada data</div>
@endforelse
