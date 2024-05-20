<div class="tab-pane fade show" id="custom-content-above-penanggung_jawab" role="tabpanel" aria-labelledby="custom-content-below-penanggung_jawab-tab">
    <div class="row overflow-auto">
        <div class="col-md-6">
            <table class="table">
                <tr>
                    <td class="text-bold text-darkblue">PPTK</td>
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
                    <td class="text-bold text-darkblue">PEMIMPIN TEKNIS</td>
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
                    <td class="text-bold text-darkblue">PENYEDIA JASA</td>
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
</div>
