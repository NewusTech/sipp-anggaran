<div class="tab-pane fade show {{session('tab') == 'anggaran'? 'active' : ''}}" id="custom-content-above-anggaran" role="tabpanel" aria-labelledby="custom-content-below-anggaran-tab">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-responsive" id="table_anggran">
                <thead>
                    <tr>
                        <th class="text-darkblue">Daya Serap</th>
                        <th class="text-darkblue">Alokasi</th>
                        <th class="text-darkblue">Tanggal</th>
                        <th class="text-darkblue">Keterangan</th>
                        @if($isEdit)
                        <th class="text-darkblue text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggaran as $agr)
                    <tr>
                        <td>{{ $agr->daya_serap }}</td>
                        <td>Rp{{ number_format($agr->daya_serap_kontrak) }} </td>
                        <td>{{ $agr->tanggal->format('d-m-Y') }}</td>
                        <td style="overflow-wrap: anywhere;">{{ $agr->keterangan ?? '-' }}</td>
                        @if($isEdit)
                        <td>
                            <button type="button" style="color: white;" class="btn btn-block btn-warning btn-xs" data-toggle="modal" data-target="#modal-lg-edit-anggaran-{{ $agr->id }}"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-block btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete-anggaran-{{ $agr->id }}"><i class="fas fa-trash"></i></button>

                            <div class="modal fade" id="modal-delete-anggaran-{{$agr->id}}">
                                <form action="{{ route('backend.detail_anggaran.destroy', $agr->id) }}" method="POST" id="delete_anggaran">
                                    @method('DELETE')
                                    @csrf
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><strong> Hapus Data Anggran </strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <span class="text-gray">Anda yakin Hapus data?</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" id="btn_update" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </form>
                            </div>
                            <div class="modal fade" id="modal-lg-edit-anggaran-{{$agr->id}}">
                                <form action="{{ route('backend.detail_anggaran.update', $agr) }}" method="POST" id="update_data_anggaran">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><strong> Edit Data Anggaran </strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <input type="text" hidden="true" name="detail_kegiatan_id" value="{{ request()->detail_kegiatan_id }}">
                                                                    <div class="form-group">
																																			<label class="text-darkblue">Daya Serap</label>
																																			<input type="text" class="form-control" name="daya_serap" value="{{$agr->daya_serap}}" placeholder="Silahkan masukan daya serap" required>
																																			<span class="text-gray text-sm">Sisa Anggaran : Rp {{ number_format($detail->pagu - $detail->realisasi) ?? '-'  }}</span>
																																		</div>
																																		<div class="form-group">
                                                                        <label class="text-darkblue">Alokasi</label>
                                                                        <input type="number" class="form-control" name="daya_serap_kontrak" value="{{$agr->daya_serap_kontrak}}"  placeholder="Silahkan masukan sisa" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="text-darkblue">Tanggal</label>
                                                                        <input type="date" class="form-control" name="tanggal"  value="{{$agr->tanggal}}" placeholder="Silahkan masukan tanggal" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="text-darkblue">Keterangan</label>
                                                                        <input type="text" class="form-control" name="keterangan" value="{{$agr->keterangan}}" placeholder="Silahkan masukan keterangan">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </form>
                                <!-- /.modal-dialog -->
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
						
            @if($isEdit)
            <div class="text-right" style="margin-bottom: 2.25rem">
                @can('ubah detail kegiatan')
                    <button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modal-lg-edit-anggaran"><i class="fas fa-edit"></i> Edit Data</button>
                @endcan
            </div>
            @endif
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <td class="text-darkblue" colspan="1">Sisa Waktu Pengerjaan : <span class="text-bold">{{(strtotime($detail->akhir_kontrak->format('Y-m-d')) - strtotime(now()->format('Y-m-d'))) / 60 / 60 / 24 }} Hari</span></td>
                        <td></td>
                        <td class="text-darkblue text-bold">Target</td>
                        <td class="text-darkblue text-bold">Real</td>
                        <td class="text-darkblue text-bold">Dev</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-bold text-darkblue">Daya Serap Kontrak</td>
                        <td><span id="daya_serap_kontrak">Rp {{ number_format($anggaran->sum('daya_serap_kontrak')) ?? '-'  }}</span></td>
                        <td>{{ $detail->target ?? '-' }} Hari</td>
                        <td>{{ $detail->real ?? '-' }} Hari</td>
                        <td>{{ $detail->dev ?? '-' }} Hari</td>
                    </tr>
                    <tr>
                        <td class="text-bold text-darkblue">Sisa Kontrak</td>
                        <td colspan="4"><span id="sisa_kontrak">Rp {{ number_format($kegiatan->alokasi - $anggaran->sum('daya_serap_kontrak')) ?? '-'  }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-bold text-darkblue">Sisa Anggaran</td>
                        <td colspan="4"><span id="sisa_anggaran">Rp {{ number_format($detail->pagu - $detail->realisasi) ?? '-'  }}</span></td>

                    </tr>
										<tr>
											<td class="text-bold text-darkblue">Progress</td>
											<td colspan="4">
												<div class="progress">
													<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{$detail->progress}}"
													aria-valuemin="0" aria-valuemax="100" style="width:{{$detail->progress}}%">
														{{$detail->progress}}%
													</div>
												</div>
											</td>
									</tr>
                </tbody>
            </table>
            <div id="map"></div>
            <p class="text-black">{{ $detail->alamat ?? '-'}} </p>
        </div>
    </div>
</div>

@if($isEdit)
<div class="modal fade" id="modal-lg-create-anggaran">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Data Anggaran </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.detail_anggaran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" hidden="true" name="detail_kegiatan_id" value="{{ request()->detail_kegiatan_id }}">
                            <div class="form-group">
                                <label class="text-darkblue">Daya Serap</label>
																<input type="text" class="form-control" name="daya_serap" placeholder="Silahkan masukan daya serap" required>
																<span class="text-gray text-sm">Sisa Anggaran : Rp {{ number_format($detail->pagu - $detail->realisasi) ?? '-'  }}</span>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Alokasi</label>
                                <input type="number" class="form-control" name="daya_serap_kontrak" placeholder="Silahkan masukan Alokasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" placeholder="Silahkan masukan tanggal" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" placeholder="Silahkan masukan keterangan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@include('backend.kegiatan._modal_update_anggaran')
@endif
