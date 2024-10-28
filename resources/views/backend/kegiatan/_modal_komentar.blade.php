<div class="modal fade" id="modal-lg-komentar-{{$param}}-{{$detail->id}}" >
    <form id="komentar-pengawas-form-{{$detail->id}}" action="{{ route('backend.detail_kegiatan.verifikasi', $detail->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong> Komentar {{$param}}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <textarea class="form-control" placeholder="Komentar" id="komentar{{$param}}" name="komentar_{{$param}}">{{$param == 'admin' ? $detail->komentar_admin : $detail->komentar_pengawas}}</textarea>
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