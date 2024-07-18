<div class="tab-pane fade show {{session('tab') == 'kegiatan' ? 'active' : ''}}" id="custom-content-below-kegiatan" role="tabpanel" aria-labelledby="custom-content-below-kegiatan-tab">
    <div class="row">
        <div class="col-12">
            <table id="example1" class="table table-responsive" style="width: 100% !important;">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Bidang</th>
                        <th>Nama Kegiatan</th>
                        <th style="text-align: end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatans as $item)
                    <tr>
                        <td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{$item->program_name}}
                        </td>
                        <td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{$item->bidang->name}}
                        </td>
                        <td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{$item->title}}
                        </td>
                        <td class="btn-action">
                            <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-kegiatan-{{$item->id}}"><i class="fas fa-edit"></i> </button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-kegiatan-{{$item->id}}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @include('backend.sub-kegiatan._modal_delete', ['action' => 'deleteKegiatan'])
                    @include('backend.sub-kegiatan._modal_edit', ['action' => 'editKegiatan'])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
