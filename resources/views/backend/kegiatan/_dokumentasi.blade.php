<div class="tab-pane fade show {{session('tab') == 'dokumentasi'? 'active' : ''}}" id="custom-content-above-dokumentasi" role="tabpanel" aria-labelledby="custom-content-below-dokumentasi-tab">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-responsive" id="table_dokumentasi">
                <thead>
                    <tr>
                        <th class="text-darkblue">No.</th>
                        <th class="text-darkblue">Judul</th>
                        <th class="text-darkblue">Keterangan</th>
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
                            <button type="button" style="color: white;" class="view_file btn btn-info btn-xs show-file" data-id="{{$dok->id}}"
                                    data-toggle="modal"><i class="fas fa-eye"></i> </button>
                            @if($isEdit)
                            <button type="button" style="color: white;" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-lg-edit-file-{{$dok->id}}"><i class="fas fa-edit"></i> </button>
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete-file-{{$dok->id}}"><i class="fas fa-trash"></i> </button>
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
                                                        <label class="text-darkblue">Judul</label>
                                                        <input type="text" class="form-control" name="name" value="{{$dok->name}}" placeholder="Silahkan masukan judul dokumentasi" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="text-darkblue">Keterangan</label>
                                                        <input type="text" class="form-control" value="{{$dok->keterangan}}" name="keterangan" placeholder="Silahkan masukan keterangan dokumentasi" required>
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

        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header text-bold text-darkblue">
                    Gallery
                </div>
                <div class="card-action-right mt-1">
                    <button class="btn btn-primary btn-sm rounded" id="downloadFiles"><i class="fas fa-download"></i> Download</button>
                </div>
                <div class="card-body">
                    @foreach($dokumentasi as $key => $dok)
                        <div class="row row-file file-preview-{{ $dok->id }}" id="{{ $dok->id }}" style="display: {{ $key == 0 ? '' : 'none' }};">
                            @foreach($dok->files as $file)
                                <label class="image-checkbox check-all-{{$dok->id}} col-md-2 mb-2">
                                    @if (str_contains($file->type, 'image'))
                                        <img src="{{ asset('uploads') . "/" . $file->path }}" class="files-list-{{$dok->id}}" data-path="{{ asset('uploads') . "/" . $file->path }}" style="width: 100%; height: 100%; border-radius: 10px;"/>
                                        <i class="fa fa-check"></i>
                                    @elseif(str_contains($file->type, 'sheet'))
                                        <img src="{{ asset('/image/excel.png') }}" class="files-list-{{$dok->id}}" data-path="{{ asset('uploads') . "/" . $file->path }}" style="width: 100%; height: 100%; border-radius: 10px;"/>
                                        <i class="fa fa-check"></i>
                                    @elseif(str_contains($file->type, 'pdf'))
                                        <img src="{{ asset('/image/pdf.png') }}" class="files-list-{{$dok->id}}" data-path="{{ asset('uploads') . "/" . $file->path }}" style="width: 100%; height: 100%; border-radius: 10px;"/>
                                        <i class="fa fa-check"></i>
                                    @elseif(str_contains($file->type, 'wordprocessingml'))
                                        <img src="{{ asset('/image/word.png') }}" class="files-list-{{$dok->id}}" data-path="{{ asset('uploads') . "/" . $file->path }}" style="width: 100%; height: 100%; border-radius: 10px;"/>
                                        <i class="fa fa-check"></i>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
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
                                <label class="text-darkblue">Judul</label>
                                <input type="text" class="form-control" name="name" placeholder="Silahkan masukan judul dokumentasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Keterangan</label>
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
