@if ($action == 'addSubKegiatan')

<div class="modal fade" id="modal-add-sub-kegiatan" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Sub Kegiatan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('backend.sub_kegiatan.store')}}" method="POST" id="submit_bidang">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Kegiatan</label>
                                <select name="kegiatan_id" id="kegiatan_id" class="form-control" required>
                                    <option selected>-- Pilih Kegiatan --</option>
                                    @foreach ($kegiatans as $kegiatan)
                                    <option value="{{$kegiatan->id}}">{{$kegiatan->bidang->name}} | {{$kegiatan->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Kode</label>
                                <input type="text" class="form-control" name="kode_sub_kegiatan" placeholder="Silahkan masukan Kode Sub Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nama Sub Kegiatan</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan nama Sub Kegiatan" required>
                            </div>
                            <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@elseif ($action == 'addKegiatan')
<div class="modal fade" id="modal-add-kegiatan" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Kegiatan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.kegiatan.store') }}" method="POST" id="submitKegiatan">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Program</label>
                                <select name="program" id="program" class="form-control" required>
                                    <option selected>-- Pilih Program --</option>
                                    @foreach ($programs as $program)
                                    <option style="overflow: hidden;" value="{{$program->id}}">{{$program->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Bidang</label>
                                <select name="bidang_id" id="bidang_id" class="form-control" required>
                                    <option selected>-- Pilih Bidang --</option>
                                    @foreach ($bidangs as $bidang)
                                    <option value="{{$bidang->id}}">{{$bidang->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Nama Kegiatan</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan Nama Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Tahun</label>
                                <input type="number" class="form-control" name="tahun" placeholder="Silahkan masukan Nama Kegiatan" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Kode</label>
                                <input type="text" class="form-control" name="no_rek" placeholder="Silahkan masukan Kegiatan" required>
                            </div>
                            <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endif
