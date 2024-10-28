<div class="tab-pane fade show {{ session('tab') == 'dokumentasi' ? 'active' : '' }}"
    id="custom-content-above-dokumentasi" role="tabpanel" aria-labelledby="custom-content-below-dokumentasi-tab">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table" id="table_dokumentasi">
                <thead>
                    <tr>
                        <th class="text-darkblue">No.</th>
                        <th class="text-darkblue">Minggu-ke</th>
                        <th class="text-darkblue">Progres (%)</th>
                        <th class="text-darkblue text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($dokumentasi as $dok)
                        <tr>
                            <td style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">{{ $no }}</td>
                            <td style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">{{ $dok->name }}</td>
                            <td style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">{{ $dok->keterangan }}</td>
                            <td style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">
                                @if ($isEdit)
                                    <div class="d-flex gap-2">
                                        <button type="button" style="color: white; margin-right: 5px"
                                            class="btn btn-warning" data-toggle="modal"
                                            data-target="#modal-lg-edit-file-{{ $dok->id }}"><i
                                                class="fas fa-edit"></i> </button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#modal-delete-file-{{ $dok->id }}"><i
                                                class="fas fa-trash"></i> </button>
                                    </div>
                                @endif
                            </td>

                            <div class="modal fade" id="modal-lg-edit-file-{{ $dok->id }}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><strong> Data Dokumentasi </strong></h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('backend.detail_anggaran.dokumentasi.update', $dok) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-body">
                                                <input type="text" hidden="true" name="detail_kegiatan_id"
                                                    value="{{ request()->detail_kegiatan_id }}">
                                                <div class="row mx-0">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="text-darkblue">Minggu Ke</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $dok->name }}"
                                                                placeholder="Silahkan masukan minggu ke" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-darkblue">Progres</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $dok->keterangan }}" name="keterangan"
                                                                placeholder="Silahkan masukan keterangan progres"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-darkblue">File</label>
                                                            <input type="file" class="form-control"
                                                                name="file_name[]" placeholder="Silahkan masukan file"
                                                                multiple required>
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

                            <div class="modal fade" id="modal-delete-file-{{ $dok->id }}">
                                <form action="{{ route('backend.detail_anggaran.dokumentasi.destroy', $dok) }}"
                                    method="POST" id="delete_dokumentasi">
                                    @method('DELETE')
                                    @csrf
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><strong> Hapus Data Dokumentasi </strong></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mx-0">
                                                    <div class="col-sm-12">
                                                        <span class="text-gray">Anda yakin Hapus data?</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" id="btn_update" class="btn btn-danger"><i
                                                        class="fas fa-trash"></i> Hapus</button>
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
    </div>

    <div class="col-md-12 mt-4">
        <div class="card p-0">
            <div class="card-header text-bold text-darkblue">
                Gallery
            </div>
            <div class="card-body p-1 d-flex flex-wrap">
                @foreach ($dokumentasi as $key => $dok)
                    <div class="card m-2" style="width: 250px;">
                        <div class="card-header text-center">
                            Progres: {{ $dok->keterangan }} %
                        </div>
                        <div class="card-body p-2 d-flex justify-content-center">
                            @foreach ($dok->files as $file)
                                <button style="border:none; background:none;" data-toggle="modal"
                                    data-target="#modal-preview-file-{{ $dok->id }}">
                                    <img src="{{ asset('uploads') . '/' . $file->path }}"
                                        class="files-list-{{ $dok->id }}"
                                        data-path="{{ asset('uploads') . '/' . $file->path }}"
                                        style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;" />
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal Preview -->
                    @foreach ($dok->files as $file)
                        <div class="modal fade" id="modal-preview-file-{{ $dok->id }}">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><strong>Preview Dokumentasi</strong></h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ asset('uploads') . '/' . $file->path }}"
                                            class="files-list-{{ $dok->id }}"
                                            style="width: 100%; height: 100%; object-fit: contain; border-radius: 10px;" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>



</div>

<div class="modal fade" id="modal-lg-create-dokumentasi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Data Dokumentasi </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.detail_anggaran.dokumentasi.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="text" hidden="true" name="detail_kegiatan_id"
                        value="{{ request()->detail_kegiatan_id }}">
                    <div class="row mx-0">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="text-darkblue">Minggu Ke</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Silahkan masukan judul dokumentasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Progres (%)</label>
                                <input type="text" class="form-control" name="keterangan"
                                    placeholder="Silahkan masukan keterangan dokumentasi" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">File</label>
                                <input type="file" class="form-control" name="file_name[]"
                                    placeholder="Silahkan masukan file" multiple required>
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

