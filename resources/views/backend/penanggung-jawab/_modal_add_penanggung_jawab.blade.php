<div class="modal fade" id="modal-lg-create" style="padding-right: 17px; ">
    <form action="" method="POST">
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