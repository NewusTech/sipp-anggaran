<div class="modal fade" id="modal-md-edit-progres-{{ $item->id }}" style="padding-right: 17px; ">
    <div class="modal-dialog modal-md">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Edit Progres {{$item->jenis_progres}} </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="comtainer">

                <form method="POST" action="{{ route('backend.detail_anggaran.update_progres', ['id' => $item->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="row mx-0">
                        <input type="hidden" name="jenis_progres" value="{{$item->jenis_progres}}">
                        <div class="col">
                            <input type="date" class="form-control form-control-sm" name="tanggal" required value="{{$item->tanggal}}">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control form-control-sm" name="nilai" required value="{{$item->nilai}}">
                        </div>
                    </div>
                    <div class="text-left mt-3" style="margin-bottom: 2.25rem">
                        <button type="submit" class="btn btn-primary btn-sm text-white"><i class="fas fa-save mx-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>