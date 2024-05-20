<div class="modal fade" id="modal-lg-edit-anggaran" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Edit Data </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.detail_kegiatan.update.detail', $detail) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="text-darkblue">Target</label>
                                <input type="text" class="form-control" value="{{ $detail->target }}" name="target" placeholder="Silahkan masukan target">
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Real</label>
                                <input type="text" class="form-control" value="{{ $detail->real }}" name="real" placeholder="Silahkan masukan real">
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Dev</label>
                                <input type="text" class="form-control" value="{{ $detail->dev }}" name="dev" placeholder="Silahkan masukan dev">
                            </div>
														<div class="form-group">
															<label class="text-darkblue">Progress (%)</label>
															<input type="number" class="form-control" value="{{ $detail->progress }}" name="progress" id="progress" placeholder="Silahkan masukan progress 1-100">
															<span class="text-danger" id="progress-error"></span>
														</div>
														<label class="text-darkblue">Maps</label>
														<span>(Klik Untuk Mendapatkan Koordinat !)</span>
														<div class="card">
															<div class="card-body">
																<div id="updateMap"></div>
																<input type="hidden" class="form-control" name="latitude" value="{{ $detail->latitude }}" id="latitude" placeholder="Silahkan masukan latitude">
                                <input type="hidden" class="form-control" name="longitude" value="{{ $detail->longitude }}" id="longitude" placeholder="Silahkan masukan longitude">
															</div>
														</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary" id="btn-update-anggaran">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
