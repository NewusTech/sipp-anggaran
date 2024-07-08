<div class="modal fade" id="modal-lg-edit-pptk-pr-{{$detail->id}}" style="padding-right: 17px; ">
    <form action="{{ route('backend.detail_kegiatan.update.pengawas', $detail->id) }}" method="POST">
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
                            <div class="form-group">
                                <label class="text-darkblue">Pilih Pengawas</label>
                                <select name="penanggung_jawab_id" id="penanggung_jawab_id" class="form-control" required>
                                    <option selected>-- Pilih Pengawas --</option>
                                    @foreach ($listPJ as $value)
                                    <option value="{{$value->id}}" {{$detail->penanggung_jawab_id == $value->id ? 'selected' : '' }}>{{$value->pptk_name}} - {{$value->id}}</option>
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