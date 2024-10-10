<div class="tab-pane fade show {{session('tab') == ''? 'active' : ''}}" id="custom-content-above-detail" role="tabpanel" aria-labelledby="custom-content-below-detail-tab">
    <div class="row">
        <div class="col-12">
            <table class="table table-responsive">
                <tr>
                    <td class="text-bold text-darkblue">Program</td>
                    <td>{{ $kegiatan->program }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Kegiatan Pekerjaan</td>
                    <td>{{ $detail->kegiatan->title }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Sub Kegiatan Pekerjaan</td>
                    <td>{{ $detail->title }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nomor Pekerjaan</td>
                    <td>{{ $detail->no_detail_kegiatan }}</td>
                </tr>

                <tr>
                    <td class="text-bold text-darkblue">Tahun</td>
                    <td>{{ $detail->kegiatan->tahun }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Jenis Pengadaan</td>
                    <td>{{ $detail->jenis_pengadaan }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nomor Kontrak</td>
                    <td>{{ $detail->no_kontrak }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nilai Kontrak</td>
                    <td>Rp. {{ $kegiatan->alokasi ? number_format($kegiatan->alokasi) : '-' }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Penyedia Jasa</td>
                    <td>{{ $detail->penyedia_jasa }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Nomor SPMK</td>
                    <td>{{ $detail->no_spmk }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Realisasi</td>
                    <td>Rp. {{$detail->realisasi ? number_format($detail->realisasi) : '-' }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Awal Kontrak</td>
                    <td>{{ $detail->awal_kontrak?  $detail->awal_kontrak : "-" }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Akhir Kontrak</td>
                    <td>{{ $detail->akhir_kontrak ? $detail->akhir_kontrak  : "-" }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Target Pekerjaan</td>
                    <td>{{ $detail->target }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
