<div class="tab-pane fade show" id="custom-content-above-penanggung_jawab" role="tabpanel" aria-labelledby="custom-content-below-penanggung_jawab-tab">
    <div class="d-flex align-items-center justify-content-end">
        <button type="button" style="color: white; max-width: 10%" class="btn btn-block btn-warning btn-sm " data-toggle="modal" data-target="#modal-lg-edit-pptk-pr-{{$detail->id}}"><i class="fas fa-edit"></i>Penanggung Jawab</button>
    </div>
    <div class="row overflow-auto">
        <div class="col-md-6">
            <table class="table">
                <tr>
                    <td class="text-bold text-darkblue">PENGAWAS</td>
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
                <tr>
                    <td class="text-bold text-darkblue">ADMIN</td>
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

        <div class="col-md-12">
            <table class="table">
                <tr>
                    <td class="text-bold text-darkblue">KONTRAKTOR</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nama</td>
                    <td>{{$detail->penyedia->name ?? '-'}}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Telepon</td>
                    <td>{{$detail->penyedia->telepon ?? '-'}}</td>
                </tr>
            </table>
        </div>
    </div>
    @include('backend.kegiatan._modal_penanggung_jawab')
</div>
