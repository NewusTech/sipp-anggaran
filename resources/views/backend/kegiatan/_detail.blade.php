{{-- <style>
    @media(max-width: 576px) {
        #detailKegiatan {
            display: none;
        }

</style> --}}
<div class="tab-pane fade show {{session('tab') == ''? 'active' : ''}}" id="custom-content-above-detail" role="tabpanel" aria-labelledby="custom-content-below-detail-tab">
    <div class="row mx-0">
        <div class="col-12">
            <table class="table d-none d-md-block table-responsive">
                <tr>
                    <td class="text-bold text-darkblue mb-1">Program</td>
                    <td>{{ $kegiatan->program }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Kegiatan Pekerjaan</td>
                    <td>{{ $detail->kegiatan->title }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Sub Kegiatan Pekerjaan</td>
                    <td>{{ $detail->title }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Nomor Pekerjaan</td>
                    <td>{{ $detail->no_detail_kegiatan }}</td>
                </tr>

                <tr>
                    <td class="text-bold text-darkblue mb-1">Tahun</td>
                    <td>{{ $detail->kegiatan->tahun }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Jenis Pengadaan</td>
                    <td>{{ $detail->jenis_pengadaan }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Nomor Kontrak</td>
                    <td>{{ $detail->no_kontrak }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Nilai Kontrak</td>
                    <td>Rp. {{ $kegiatan->alokasi ? number_format($kegiatan->alokasi) : '-' }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Penyedia Jasa</td>
                    <td>{{ $detail->penyedia_jasa }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Nomor SPMK</td>
                    <td>{{ $detail->no_spmk }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Realisasi</td>
                    <td>Rp. {{$detail->realisasi ? number_format($detail->realisasi) : '-' }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Awal Kontrak</td>
                    <td>{{ $detail->awal_kontrak?  $detail->awal_kontrak : "-" }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Akhir Kontrak</td>
                    <td>{{ $detail->akhir_kontrak ? $detail->akhir_kontrak  : "-" }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue mb-1">Target Pekerjaan</td>
                    <td>{{ $detail->target }}</td>
                </tr>
            </table>
            {{-- card --}}
            <div class="card d-block d-md-none w-full mx-0">
                <div class="card-body w-full mx-0">
                    <div class="row mx-0">
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Program:</p>
                            <p>{{ $kegiatan->program }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Kegiatan Pekerjaan:</p>
                            <p>{{ $detail->kegiatan->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Sub Kegiatan Pekerjaan:</p>
                            <p>{{ $detail->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Nomor Pekerjaan:</p>
                            <p>{{ $detail->no_detail_kegiatan }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Tahun:</p>
                            <p>{{ $detail->kegiatan->tahun }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Jenis Pengadaan:</p>
                            <p>{{ $detail->jenis_pengadaan }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Nomor Kontrak:</p>
                            <p>{{ $detail->no_kontrak }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Nilai Kontrak:</p>
                            <p>Rp. {{ $kegiatan->alokasi ? number_format($kegiatan->alokasi) : '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Penyedia Jasa:</p>
                            <p>{{ $detail->penyedia_jasa }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Nomor SPMK:</p>
                            <p>{{ $detail->no_spmk }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Realisasi:</p>
                            <p>Rp. {{ $detail->realisasi ? number_format($detail->realisasi) : '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Awal Kontrak:</p>
                            <p>{{ $detail->awal_kontrak ? $detail->awal_kontrak : "-" }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Akhir Kontrak:</p>
                            <p>{{ $detail->akhir_kontrak ? $detail->akhir_kontrak : "-" }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-bold text-darkblue mb-1">Target Pekerjaan:</p>
                            <p>{{ $detail->target }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
