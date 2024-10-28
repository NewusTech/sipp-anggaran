<div class="tab-pane fade show {{session('tab') == 'penanggung_jawab'? 'active' : ''}}" id="custom-content-above-penanggung_jawab" role="tabpanel" aria-labelledby="custom-content-below-penanggung_jawab-tab">
    <div class="mt-3 ml-4">
        @can('ubah detail kegiatan')
        <button type="button" style="color: white; width: 200px;" class="btn btn-block btn-warning btn-sm " data-toggle="modal" data-target="#modal-lg-edit-pptk-pr-{{$detail->id}}"><i class="fas fa-edit"></i>Penanggung Jawab</button>
        @endcan
    </div>
    <div class="row d-none d-md-flex overflow-auto">
        <div class="col-md-6">
            <table class="table">
                <tr class="bg-secondary">
                    <td class="text-bold text-white">PENGAWAS</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nama</td>
                    <td>{{$kegiatan->penanggung->pptk_name ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">NIP</td>
                    <td>{{$kegiatan->penanggung->pptk_nip ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Email</td>
                    <td>{{$kegiatan->penanggung->pptk_email ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Telepon</td>
                    <td>{{$kegiatan->penanggung->pptk_telpon ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Bidang</td>
                    <td>{{$kegiatan->penanggung->bidang_pptk->name ?? '-'}}</td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table">
                <tr class="bg-secondary">
                    <td class="text-bold text-white">ADMIN</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nama</td>
                    <td>{{$kegiatan->penanggung->ppk_name ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">NIP</td>
                    <td>{{$kegiatan->penanggung->ppk_nip ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Email</td>
                    <td>{{$kegiatan->penanggung->ppk_email ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Telepon</td>
                    <td>{{$kegiatan->penanggung->ppk_telpon ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Bidang</td>
                    <td>{{$kegiatan->penanggung->bidang_ppk->name ?? '-'}}</td>
                </tr>
            </table>
        </div>

        <div class="col-md-12 mt-2">
            <table class="table">
                <tr class="bg-secondary">
                    <td class="text-bold text-white">PENYEDIA JASA</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nama</td>
                    <td>{{$detail->penyedia_jasa ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Telepon</td>
                    <td>{{$detail->penyedia->telepon ?? '-'}}</td>
                </tr>
            </table>
        </div>
    </div>
    {{-- card --}}
    <div class="row d-block d-md-none overflow-auto">
        <div class="col-md-6 mx-1 px-0">
            <h6 class="text-secondary">PENGAWAS</h6>
            <div class="card mb-2">
                <div class="card-body">
                    <h6 class="text-bold text-darkblue">Nama: <span class="text-dark">{{ $kegiatan->penanggung->pptk_name ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">NIP: <span class="text-dark">{{ $kegiatan->penanggung->pptk_nip ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Email: <span class="text-dark">{{ $kegiatan->penanggung->pptk_email ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Telepon: <span class="text-dark">{{ $kegiatan->penanggung->pptk_telpon ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Bidang: <span class="text-dark">{{ $kegiatan->penanggung->bidang_pptk->name ?? '-' }}</span></h6>
                </div>
            </div>
        </div>

        <div class="col-md-6 mx-1 px-0">
            <h6 class="text-secondary">ADMIN</h6>
            <div class="card mb-2">
                <div class="card-body">
                    <h6 class="text-bold text-darkblue">Nama: <span class="text-dark">{{ $kegiatan->penanggung->ppk_name ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">NIP: <span class="text-dark">{{ $kegiatan->penanggung->ppk_nip ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Email: <span class="text-dark">{{ $kegiatan->penanggung->ppk_email ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Telepon: <span class="text-dark">{{ $kegiatan->penanggung->ppk_telpon ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Bidang: <span class="text-dark">{{ $kegiatan->penanggung->bidang_ppk->name ?? '-' }}</span></h6>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-2 mx-1 px-0">
            <h6 class="text-secondary">PENYEDIA JASA</h6>
            <div class="card mb-2">
                <div class="card-body">
                    <h6 class="text-bold text-darkblue">Nama: <span class="text-dark">{{ $detail->penyedia_jasa ?? '-' }}</span></h6>
                    <h6 class="text-bold text-darkblue">Telepon: <span class="text-dark">{{ $detail->penyedia->telepon ?? '-' }}</span></h6>
                </div>
            </div>
        </div>
    </div>
    @include('backend.kegiatan._modal_penanggung_jawab')
</div>

