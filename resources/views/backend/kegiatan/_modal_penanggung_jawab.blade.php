<div class="modal fade" id="modal-lg-edit-pptk-pr-{{$detail->id}}" style="padding-right: 17px; ">
    <form action="{{ route('backend.kegiatan.pptk', $detail->id) }}" method="POST">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong> Edit Pengawas / Admin </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <h3>Pengawas</h3>
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" class="form-control" name="pptk_name" value="{{$kegiatan->penanggung->pptk_name ?? ''}}" placeholder="Silahkan masukan Nama" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">NIP</label>
                                <input type="text" class="form-control" name="pptk_nip" value="{{$kegiatan->penanggung->pptk_nip ?? ''}}" placeholder="Silahkan masukan NIP" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="text" class="form-control" name="pptk_email" value="{{$kegiatan->penanggung->pptk_email ?? ''}}" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telpon</label>
                                <input type="text" class="form-control" name="pptk_telpon" value="{{$kegiatan->penanggung->pptk_telpon ?? ''}}" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Bidang</label>
                                <select name="pptk_bidang_id" id="pptk_bidang_id" class="form-control" required>
                                    <option selected>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $value)
                                    <option value="{{$value->id}}" {{$kegiatan->penanggung ? $kegiatan->penanggung->pptk_bidang_id == $value->id ? 'selected' : ''  : ''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <h3>Admin</h3>
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" class="form-control" name="ppk_name" value="{{$kegiatan->penanggung->ppk_name ?? ''}}" placeholder="Silahkan masukan judul Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">NIP</label>
                                <input type="text" class="form-control" name="ppk_nip" value="{{$kegiatan->penanggung->ppk_nip ?? ''}}" placeholder="Silahkan masukan NIP" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="text" class="form-control" name="ppk_email" value="{{$kegiatan->penanggung->ppk_email ?? ''}}" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telpon</label>
                                <input type="text" class="form-control" name="ppk_telpon" value="{{$kegiatan->penanggung->ppk_telpon ?? ''}}" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Bidang</label>
                                <select name="ppk_bidang_id" id="ppk_bidang_id" class="form-control" required>
                                    <option selected>-- Pilih Bidang --</option>
                                    @foreach ($bidang as $value)
                                    <option value="{{$value->id}}" {{$kegiatan->penanggung ? $kegiatan->penanggung->ppk_bidang_id == $value->id ? 'selected' : ''  : ''}}>{{$value->name}}</option>
                                    @endforeach
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
