<div class="modal fade" id="modal-lg-edit-detail-{{ $detail->id }}" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Edit Detail Pekerjaan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.detail_kegiatan.update.detail_kegiatan', $detail) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Judul Pekerjaan</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul pekerjaan" value="{{ $detail->title }}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nomor Pekerjaan</label>
                                <input type="text" class="form-control" name="no_detail_kegiatan" placeholder="Silahkan masukan nomor pekerjaan" value="{{ $detail->no_detail_kegiatan }}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nomor SPMK</label>
                                <input type="text" class="form-control" name="no_spmk" placeholder="Silahkan masukan nomor spmk" value="{{ $detail->no_spmk }}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Penyedia Jasa</label>
                                <input type="text" class="form-control" name="penyedia_jasa" placeholder="Silahkan masukan penyedia jasa" value="{{ $detail->penyedia_jasa }}" required>
                            </div>
                            {{-- <div class="form-group">
                                <label class="text-darkblue">Penyedia Jasa</label>
                                <select class="form-control" name="penyedia_jasa_id" id="penyedia_jasa_id" required>
                                    <option value="">-- Pilih Penyedia Jasa --</option>
                                    @foreach ($penyedia_jasa as $item)
                                    <option value="{{ $item->id }}" {{$item->id == $detail->penyedia_jasa_id ? 'selected' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label class="text-darkblue">Nomor Kontrak</label>
                                <input type="text" hidden="true" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                <input type="text" class="form-control" name="no_kontrak" placeholder="Silahkan masukan nomor kontrak" value="{{$detail->no_kontrak}}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nilai Kontrak</label>
                                <input type="text" class="form-control" name="nilai_kontrak" placeholder="Silahkan masukan nilai kontrak" value="{{ $detail->nilai_kontrak }}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Jenis Pengadaan</label>
                                <input type="text" class="form-control" name="jenis_pengadaan" placeholder="Silahkan masukan jenis pengadaan" value="{{$detail->jenis_pengadaan}}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Awal Kontrak</label>
                                <input type="date" class="form-control" name="awal_kontrak" placeholder="Silahkan masukan awal kontrak" value={{\Carbon\Carbon::parse($detail->awal_kontrak)->format('Y-m-d')}} required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Akhir Kontrak</label>
                                <input type="date" class="form-control" name="akhir_kontrak" placeholder="Silahkan masukan akhir kontrak" value={{\Carbon\Carbon::parse($detail->akhir_kontrak)->format('Y-m-d')}} required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Target</label>
                                <input type="text" class="form-control" name="target" placeholder="Silahkan masukan target satuan hari" value="{{$detail->target}}" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Lokasi Pekerjaan</label>
                                <textarea name="alamat" class="form-control" id="alamat" cols="30" rows="5">{{$detail->alamat}}</textarea>
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
