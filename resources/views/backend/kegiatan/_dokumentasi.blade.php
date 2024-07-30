<div class="tab-pane fade show {{session('tab') == 'dokumentasi'? 'active' : ''}}" id="custom-content-above-dokumentasi" role="tabpanel" aria-labelledby="custom-content-below-dokumentasi-tab">
    <div class="col-12">
        <table class="table table-responsive" id="table_dokumentasi">
            <thead>
                <tr>
                    <th class="text-darkblue">No.</th>
                    <th class="text-darkblue">Minggu-ke</th>
                    <th class="text-darkblue">Progres (%)</th>
                    <th class="text-darkblue text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no = 1;
                @endphp
                @forelse ($dokumentasi as $dok)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $dok->name }}</td>
                    <td>{{ $dok->keterangan }}</td>
                    <td>
                        @if($isEdit)
                        <button type="button" style="color: white;" class="btn btn-warning" data-toggle="modal" data-target="#modal-lg-edit-file-{{$dok->id}}"><i class="fas fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-file-{{$dok->id}}"><i class="fas fa-trash"></i> </button>
                        @endif
                    </td>

                    <div class="modal fade" id="modal-lg-edit-file-{{$dok->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><strong> Data Dokumentasi </strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('backend.detail_anggaran.dokumentasi.update', $dok) }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="modal-body">
                                        <input type="text" hidden="true" name="detail_kegiatan_id" value="{{ request()->detail_kegiatan_id }}">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="text-darkblue">Minggu Ke</label>
                                                    <input type="text" class="form-control" name="name" value="{{$dok->name}}" placeholder="Silahkan masukan minggu ke" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-darkblue">Progres</label>
                                                    <input type="text" class="form-control" value="{{$dok->keterangan}}" name="keterangan" placeholder="Silahkan masukan keterangan progres" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-darkblue">File</label>
                                                    <input type="file" class="form-control" name="file_name[]" placeholder="Silahkan masukan file" multiple required>
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
                    </div>

                    <div class="modal fade" id="modal-delete-file-{{$dok->id}}" style="padding-right: 17px; ">
                        <form action="{{ route('backend.detail_anggaran.dokumentasi.destroy', $dok) }}" method="POST" id="delete_dokumentasi">
                            @method('DELETE')
                            @csrf
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><strong> Hapus Data Dokumentasi </strong></h5>
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
                    </div>
                </tr>
                @php $no++; @endphp
                @empty

                @endforelse
            </tbody>
        </table>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header text-bold text-darkblue">
                Gallery
            </div>
            <!-- <div class="card-action-right mt-1">
                <button class="btn btn-primary btn-sm rounded" id=""><i class="fas fa-download"></i> Download</button>
            </div> -->
            <table class="table table-striped table-dokumentasi table-responsive">
                <div class="card-body d-flex">
                    <tr>
                        <th scope="row">Progres</th>
                        @foreach($dokumentasi as $key => $dok)
                        <td>{{$dok->keterangan}} %</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="row">Dokumentasi</th>
                        @foreach($dokumentasi as $key => $dok)
                        @foreach($dok->files as $file)
                        <td>
                            <button style="border:none; background:none;" data-toggle="modal" data-target="#modal-preview-file-{{$dok->id}}">
                                <img src="{{ asset('uploads') . "/" . $file->path }}" class="files-list-{{$dok->id}}" data-path="{{ asset('uploads') . "/" . $file->path }}" style="width: 250px; height: 150px; object-fit: cover; border-radius: 10px;" />
                            </button>
                        </td>

                        <!-- Modal Preview -->
                        <div class="modal fade" id="modal-preview-file-{{$dok->id}}">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><strong> Preview Dokumentasi </strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="position: unset; height: fit-content">
                                        <div class="col-lg-12">
                                            <img src="{{ asset('uploads') . "/" . $file->path }}" class="files-list-{{$dok->id}}" data-path="{{ asset('uploads') . "/" . $file->path }}" style="width: 100%; height: 100%; object-fit: contain; border-radius: 10px;" />
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        @endforeach
                        @endforeach
                    </tr>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lg-create-dokumentasi" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Data Dokumentasi </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.detail_anggaran.dokumentasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="text" hidden="true" name="detail_kegiatan_id" value="{{ request()->detail_kegiatan_id }}">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="text-darkblue">Minggu Ke</label>
                                <input type="text" class="form-control" name="name" placeholder="Silahkan masukan judul dokumentasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Progres (%)</label>
                                <input type="text" class="form-control" name="keterangan" placeholder="Silahkan masukan keterangan dokumentasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">File</label>
                                <input type="file" class="form-control" name="file_name[]" placeholder="Silahkan masukan file" multiple required>
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
