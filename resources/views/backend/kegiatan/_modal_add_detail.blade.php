<div class="modal fade" id="modal-lg-tambah-detail-{{$kegiatan->id}}" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Detail Kegiatan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.detail_kegiatan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Judul</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul" required>
                            </div>
														<div class="form-group">
															<label class="text-darkblue">Penyedia Jasa</label>
															<select class="form-control" name="penyedia_jasa_id" id="penyedia_jasa_id" required>
																<option value="">-- Pilih Penyedia Jasa --</option>
                                @foreach ($penyedia_jasa as $item)
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
															</select>
													</div>
                            <div class="form-group">
                                <label class="text-darkblue">Nomor Kontrak</label>
                                <input type="text" hidden="true" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                <input type="text" class="form-control" name="no_kontrak" placeholder="Silahkan masukan nomor kontrak" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Jenis Pengadaan</label>
                                <input type="text" class="form-control" name="jenis_pengadaan" placeholder="Silahkan masukan jenis pengadaan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Awal Kontrak</label>
                                <input type="date" class="form-control" name="awal_kontrak" placeholder="Silahkan masukan awal kontrak" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Akhir Kontrak</label>
                                <input type="date" class="form-control" name="akhir_kontrak" placeholder="Silahkan masukan akhir kontrak" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Target</label>
                                <input type="text" class="form-control" name="target" placeholder="Silahkan masukan target satuan hari" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Alamat</label>
                                <textarea name="alamat" class="form-control"  id="alamat" cols="30" rows="5"></textarea>
                            </div>
														<label class="text-darkblue">Maps</label>
														<span>(Klik Untuk Mendapatkan Koordinat !)</span>
														<div class="card">
															<div class="card-body">
																<div id="mapDetail"></div>
																<input type="hidden" class="form-control" name="latitude" id="latitude" placeholder="Silahkan masukan latitude">
                                <input type="hidden" class="form-control" name="longitude" id="longitude" placeholder="Silahkan masukan longitude">
															</div>
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
