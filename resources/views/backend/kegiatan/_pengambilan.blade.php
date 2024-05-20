<div class="tab-pane fade show {{session('tab') == 'pengambilan'? 'active' : ''}}" id="custom-content-above-pengembalian" role="tabpanel" aria-labelledby="custom-content-below-pengembalian-tab">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="flex justify-content-between ">
                                <div class="flex flex-col p-2">
																	<p class="text-xs text-bold">- Program: <span class="italic">{{$program->kode}} | {{$program->name}}</span></p>
																	<p class="text-xs text-bold ml-2">- Kegiatan: <span class="italic">{{$kegiatan->no_rek}} | {{$kegiatan->title}}</span></p>
																	<p class="text-xs text-bold ml-4">- Sub Kegiatan: <span class="italic">{{$detail->no_kontrak}} | {{$detail->title}}</span></p>
                                </div>
                                <div class="right">
                                    <p>Total Pagu: Rp {{number_format($detail->pagu)}}</p>
                                    <p>Terealisasi: Rp {{number_format($detail->realisasi)}}</p>
                                    <p>Presentasi: {{$detail->realisasi > 0 ? round(($detail->realisasi/$detail->pagu)*100) : 0}} %</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="text-right" style="margin-bottom: 2.4rem;">
                                <button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modal-lg-edit-pengambilan"><i class="fas fa-edit"></i> Input Rencana Pengambilan</button>
                            </div>
                            <div class="status-item">
                                <div class="status-map">
                                    <dl>
                                        <dt style="margin-bottom: 5pt;">Belanja Operasi</dt>
                                        <dd>Alokasi : Rp {{number_format($totalbelanjaOperasi)}}</dd>
                                        <dd>Terealisasi : Rp {{number_format($totalOperasi)}}</dd>
                                        <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaOperasi - $totalOperasi)}}</dd>
                                    </dl>
                                </div>
                                <div class="status-map">
                                    <dl>
                                        <dt style="margin-bottom: 5pt;">Belanja Modal</dt>
                                        <dd>Alokasi : Rp {{number_format($totalbelanjaModal)}}</dd>
                                        <dd>Terealisasi : Rp {{number_format($totalModal)}}</dd>
                                        <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaModal - $totalModal)}}</dd>
                                    </dl>
                                </div>
                                <div class="status-map">
                                    <dl>
                                        <dt style="margin-bottom: 5pt;">Belanja Tidak Terduga</dt>
                                        <dd>Alokasi : Rp {{number_format($totalbelanjaTakTerduga)}}</dd>
                                        <dd>Terealisasi : Rp {{number_format($totalTakTerduga)}}</dd>
                                        <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaTakTerduga - $totalTakTerduga)}}</dd>
                                    </dl>
                                </div>
                                <div class="status-map">
                                    <dl>
                                        <dt style="margin-bottom: 5pt;">Belanja Transfer</dt>
                                        <dd>Alokasi : Rp {{number_format($totalbelanjaTransfer)}}</dd>
                                        <dd>Terealisasi : Rp {{number_format($totalTransfer)}}</dd>
                                        <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaTransfer - $totalTransfer)}}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>History Rencana Pengambilan</label>
                            <table class="table table-responsive" id="table_pengambilan">
                                <thead>
                                    <tr>
                                        <th class="text-darkblue">No</th>
                                        <th class="text-darkblue">Bulan</th>
                                        <th class="text-darkblue">Belanja Operasi</th>
                                        <th class="text-darkblue">Belanja Modal</th>
                                        <th class="text-darkblue">Belanja Tidak Terduga</th>
                                        <th class="text-darkblue">Belanja Transfer</th>
                                        <th class="text-darkblue">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengambilan as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ucfirst($item->bulan)}}</td>
                                            <td>Rp.{{number_format($item->belanja_operasi)}}</td>
                                            <td>Rp.{{number_format($item->belanja_modal)}}</td>
                                            <td>Rp.{{number_format($item->belanja_tak_terduga)}}</td>
                                            <td>Rp.{{number_format($item->belanja_transfer)}}</td>
                                            <td>{{$item->keterangan}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.kegiatan._modal_pengambilan')

