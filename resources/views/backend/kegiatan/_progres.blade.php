<div class="tab-pane fade show {{ session('tab') == 'progres' ? 'active' : '' }}" id="custom-content-below-progres" role="tabpanel" aria-labelledby="custom-content-belowprogres-tab">
    <div class="row">
        <!-- Progress Fisik -->
        <div class="col-md-6">
            <h4>Realisasi Fisik</h4>
            <div class="container">
                <div style="max-height: 200px; height: 200px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Fisik</th>
                                <th class="p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($progresFisik->count()>0)
                            @foreach ($progresFisik as $item)
                            <tr class="p-2">
                                <td>{{$item->tanggal}}</td>
                                <td>{{$item->nilai}}</td>
                                <td class="p-2 flex">
                                    <a id="editProgres" style="color: #f5faff" class="btn btn-warning btn-sm p-1" data-toggle="modal" data-target="#modal-md-edit-progres-{{$item->id}}"><i class="fas fa-edit"></i> Edit</a>
                                    <form id="deleteProgresForm" action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger p-1" data-toggle="modal" data-target="#modal" onclick="onDeleteProgres(`{{$item->id}}`)"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @include('backend.kegiatan._modal_edit_progres')
                            @endforeach
                            @else
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <h4>Data Kosong</h4>
                                </td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @can('update progres')
                <form action="{{ route('backend.detail_anggaran.tambah_progres', ['detail_kegiatan_id' => $detail->id]) }}" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <input type="hidden" name="jenis_progres" value="fisik">
                        <div class="col">
                            <input type="date" class="form-control form-control-sm" name="tanggal" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control form-control-sm" name="nilai" required>
                        </div>
                    </div>
                    <div class="text-left mt-3" style="margin-bottom: 2.25rem">
                        <button type="submit" class="btn btn-primary btn-sm text-white"><i class="fas fa-save mx-2"></i>Simpan</button>
                    </div>
                </form>
                @endcan
            </div>
        </div>



        <!-- Progres Keuangan -->
        <div class="col-md-6">
            <h4>Realisasi Keuangan</h4>
            <div class="container">
                <div style="max-height: 200px; height: 200px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Keuangan</th>
                                <th class="p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($progresKeuangan->count()>0)


                            @foreach ($progresKeuangan as $item)
                            <tr class="p-2">
                                <td>{{$item->tanggal}}</td>
                                <td>{{$item->nilai}}</td>
                                <td class="p-2 flex">
                                    <a id="editProgres" style="color: #f5faff" class="btn btn-warning btn-sm p-1" data-toggle="modal" data-target="#modal-md-edit-progres-{{$item->id}}"><i class="fas fa-edit"></i> Edit</a>
                                    <form id="deleteProgresForm" action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger p-1" data-toggle="modal" data-target="#modal" onclick="onDeleteProgres(`{{$item->id}}`)"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @include('backend.kegiatan._modal_edit_progres')
                            @endforeach
                            @else
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <h4>Data Kosong</h4>
                                </td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @can('update progres')
                <form action="{{ route('backend.detail_anggaran.tambah_progres', ['detail_kegiatan_id' => $detail->id]) }}" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <input type="hidden" name="jenis_progres" value="keuangan">
                        <div class="col">
                            <input type="date" class="form-control form-control-sm" name="tanggal" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control form-control-sm" name="nilai" required>
                        </div>
                    </div>
                    <div class="text-left mt-3" style="margin-bottom: 2.25rem">
                        <button type="submit" class="btn btn-primary btn-sm text-white"><i class="fas fa-save mx-2"></i>Simpan</button>
                    </div>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
