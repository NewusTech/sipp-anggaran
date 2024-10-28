@extends('layouts.main')

@section('title', 'Pengaturan Urusan')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Pengaturan') }}</span></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Pengaturan Urusan') }}</span></li>
    </ol>
</div>
@endsection

@section('main')
@if (session()->has('success'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
							<div class="card-action-right">
								<button id="addurusan" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah Urusan</button>
							</div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> DATA URUSAN </strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Daftar urusan</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row">
                            <div class="col-12">
                                <table id="example1" class="table ">
                                    <thead>
                                    <tr>
                                        <th style="width: 80%; padding:1rem 2.25rem;">Nama Urusan</th>
                                        <th style="text-align: center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($urusan as $item)
                                    <tr>
                                        <td>{{$item->kode}} | {{$item->name}}</td>
                                        <td class="btn-action">
                                            <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-lg-edit-{{$item->id}}" >
                                        <form action="{{ route('backend.urusan.update', $item->id) }}" method="POST" id="update_urusan">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"><strong> Data Urusan </strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                    <div class="col-sm-12">
                                                        <!-- text input -->
																												<div class="form-group">
																													<label class="text-darkblue">Kode</label>
																													<input type="text" class="form-control" name="kode" value="{{$item->kode}}" placeholder="Silahkan masukan Kode" required>
																												</div>
                                                        <div class="form-group">
                                                        <label class="text-darkblue">Nama Urusan</label>
                                                        <input type="text" class="form-control" name="name" value="{{$item->name}}" placeholder="Silahkan masukan nama urusan" required>
                                                        </div>
                                                        <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                <button type="submit" id="btn_update" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                            </div>
                                        </form>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <div class="modal fade" id="modal-delete-{{$item->id}}" >
                                        <form action="{{ route('backend.urusan.destroy', $item->id) }}" method="POST" id="delete_urusan">
                                            @method('DELETE')
                                            @csrf
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"><strong> Hapus Urusan </strong></h5>
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
                                        <!-- /.modal-dialog -->
                                    </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<div class="modal fade" id="modal-lg-create" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong> Data Urusan </strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('backend.urusan.store') }}" method="POST" id="submit_urusan">
                @csrf
                <div class="row">
                  <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                        <label class="text-darkblue">Kode</label>
                        <input type="text" class="form-control" name="kode" placeholder="Silahkan masukan Kode" required>
                    </div>
                    <div class="form-group">
                      <label class="text-darkblue">Nama Urusan</label>
                      <input type="text" class="form-control" name="name" placeholder="Silahkan masukan nama urusan" required>
                    </div>
                    <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                  </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" id="btn_submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "collapsed": true,
    });
    $("#example1_filter label").addClass('search');
    $(".search input").before( `
        <span class="fa fa-search"></span>
    `);
    $(".search input").attr("placeholder", "Ketik Kata Kunci");
    $("#btn_submit").on("click", function (){
        $("#submit_urusan").submit();
    });
  });
</script>
@endsection
