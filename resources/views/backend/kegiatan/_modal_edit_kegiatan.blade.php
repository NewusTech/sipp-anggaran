<div class="modal fade" id="modal-lg-edit-{{$kegiatan->id}}" style="padding-right: 17px; ">
    <form action="{{ route('backend.kegiatan.update', $kegiatan->id) }}" method="POST" id="update_kegiatan">
        @method('PUT')
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong> Edit Kegiatan </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Judul Kegiatan</label>
                                <input type="text" class="form-control" name="title" value="{{$kegiatan->title}}" placeholder="Silahkan masukan judul Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Kode Kegiatan</label>
                                <input type="text" class="form-control" name="no_rek" value="{{$kegiatan->no_rek}}" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Pagu Anggaran</label>
                                <input type="text" class="form-control" name="alokasi" value="{{$kegiatan->alokasi}}" placeholder="Silahkan masukan alokasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tahun Kegiatan</label>
                                <input type="text" class="form-control" name="tahun" value="{{$kegiatan->tahun}}" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Program</label>
                                <select name="program" id="program" class="form-control" required>
                                    <option selected>-- Pilih Program --</option>
                                    @foreach ($program as $value)
                                    <option value="{{$value->id}}" {{$value->id == $kegiatan->program ? 'selected' : ''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nomor Rekening Program</label>
                                <input type="text" class="form-control" name="no_rek_program" value="{{$kegiatan->no_rek_program}}" placeholder="Silahkan masukan nomor rekening program" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Bidang</label>
                                <select name="bidang_id" id="bidang_id" class="form-control" required>
                                    <option selected>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $value)
                                    <option value="{{$value->id}}" {{$value->id == $kegiatan->bidang_id ? 'selected' : ''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Pilih Sumber Dana</label>
                                <select name="sumber_dana" id="sumber_dana" class="form-control" required>
                                    <option selected>-- Pilih Sumber dana --</option>
                                    @foreach ($sumber_dana as $item)
                                    <option value="{{$item->id}}" {{$kegiatan->sumber_dana == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tipe Paket</label>
                                <select name="jenis_paket" id="jenis_paket" class="form-control" required>
                                    <option selected>-- Pilih Tipe Paket --</option>
                                    <option value="1" {{$kegiatan->jenis_paket == '1' ? 'selected' : ''}}>Paket Fisik</option>
                                    <option value="2" {{$kegiatan->jenis_paket == '2' ? 'selected' : ''}}>Paket Non Fisik</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
</div>