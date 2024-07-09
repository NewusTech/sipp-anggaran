@if ($action == 'add')
<div class="modal fade" id="modal-lg-create" style="padding-right: 17px; ">
    <form action="{{route('backend.penanggung_jawab.store')}}" method="POST">
        @method('POST')
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
                                <input type="text" class="form-control" name="pptk_name" placeholder="Silahkan masukan Nama" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="text" class="form-control" name="pptk_email" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telpon</label>
                                <input type="text" class="form-control" name="pptk_telpon" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>

                            <h3>Admin</h3>
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" class="form-control" name="ppk_name" placeholder="Silahkan masukan judul Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="text" class="form-control" name="ppk_email" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telpon</label>
                                <input type="text" class="form-control" name="ppk_telpon" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
@elseif ($action == 'edit')
<div class="modal fade" id="modal-lg-edit-{{$item->id}}" style="padding-right: 17px; ">
    <form action="{{route('backend.penanggung_jawab.update', $item->id)}}" method="POST">
        @method('PUT')
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
                                <input type="text" class="form-control" name="pptk_name" value="{{$item->pptk_name ?? ''}}" placeholder="Silahkan masukan Nama" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="text" class="form-control" name="pptk_email" value="{{$item->pptk_email ?? ''}}" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telpon</label>
                                <input type="text" class="form-control" name="pptk_telpon" value="{{$item->pptk_telpon ?? ''}}" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>

                            <h3>Admin</h3>
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" class="form-control" name="ppk_name" value="{{$item->ppk_name ?? ''}}" placeholder="Silahkan masukan judul Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="text" class="form-control" name="ppk_email" value="{{$item->ppk_email ?? ''}}" placeholder="Silahkan masukan nomor rekening" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telpon</label>
                                <input type="text" class="form-control" name="ppk_telpon" value="{{$item->ppk_telpon ?? ''}}" placeholder="Silahkan masukan tahun kegiatan" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
@elseif ($action == 'delete')
<div class="modal fade" id="modal-delete-{{$item->id}}" style="padding-right: 17px; ">
    <form action="{{ route('backend.penanggung_jawab.delete', $item->id) }}" method="POST" id="delete_bidang">
        @method('DELETE')
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong> Hapus Bidang </strong></h5>
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
    <!-- /.modal-dialog -->
</div>
@endif