@extends('layouts.main')

@section('title', 'DPA')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('DPA') }}</span></li>
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
                <button id="adddpa" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah</button>
              </div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> DATA DPA </strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Daftar DPA</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row overflow-auto">
                            <div class="col-12">
                                <table id="example1" class="table ">
                                    <thead>
                                    <tr>
                                        <th style="padding:1rem 2.25rem;">No DPA</th>
                                        <th>Tahun</th>
                                        <th>Urusan</th>
                                        <th style="text-align: center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dpa as $item)
                                    <tr>
                                        <td>{{$item->no_dpa}}</td>
                                        <td>{{$item->tahun}}</td>
                                        <td>{{$item->urusan}}</td>
                                        <td class="btn-action">
																						<a href="{{route('backend.dpa.show',$item->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Detail </a>
                                            <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-lg-edit-{{$item->id}}" style="padding-right: 17px; ">
                                        <form action="{{ route('backend.dpa.update', $item->id) }}" method="POST" id="update_dpa">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"><strong> Data DPA </strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
																									<div class="row">
																										<div class="col-sm-12">
																											<!-- text input -->
																											<label for="informasi">Informasi DPA</label>
																											<div class="form-group">
																													<label class="text-darkblue">No DPA</label>
																													<input type="text" class="form-control" name="no_dpa" value="{{$item->no_dpa}}" placeholder="Silahkan masukan No DPA" required>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Tahun</label>
																												<input type="number" class="form-control" name="tahun" value="{{$item->tahun}}" placeholder="Silahkan masukan Tahun" required>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Alokasi</label>
																												<input type="number" class="form-control" name="alokasi" value="{{$item->alokasi}}" placeholder="Silahkan masukan Alokasi" required>
																											</div>
																											<label for="informasi">Rincian DPA</label>
																											<div class="form-group">
																												<label class="text-darkblue">Urusan</label>
																												<select name="urusan_id" id="urusan_id" class="form-control">
																													<option value="">-- Pilih Urusan --</option>
																													@foreach ($urusan as $value)
																														<option value="{{$value->id}}" {{$item->urusan_id == $value->id ? "selected" : ''}}>{{$value->name}}</option>
																													@endforeach
																												</select>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Bidang</label>
																												<select name="bidang_id" id="bidang_id" class="form-control">
																													<option value="">-- Pilih bidang --</option>
																													@foreach ($bidang as $value)
																														<option value="{{$value->id}}" {{$item->bidang_id == $value->id ? "selected" : ''}}>{{$value->name}}</option>
																													@endforeach
																												</select>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Program</label>
																												<select name="program_id" id="program_id" class="form-control">
																													<option value="">-- Pilih program --</option>
																													@foreach ($program as $value)
																														<option value="{{$value->id}}" {{$item->program_id == $value->id ? "selected" : ''}}>{{$value->name}}</option>
																													@endforeach
																												</select>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Kegiatan</label>
																												<select name="kegiatan_id" id="kegiatan_id" class="form-control">
																													<option value="">-- Pilih kegiatan --</option>
																													@foreach ($kegiatan as $value)
																														<option value="{{$value->id}}" {{$item->kegiatan_id == $value->id ? "selected" : ''}}>{{$value->title}}</option>
																													@endforeach
																												</select>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Organisasi</label>
																												<select name="organisasi_id" id="organisasi_id" class="form-control">
																													<option value="">-- Pilih organisasi --</option>
																													@foreach ($organisasi as $value)
																														<option value="{{$value->id}}" {{$item->organisasi_id == $value->id ? "selected" : ''}}>{{$value->name}}</option>
																													@endforeach
																												</select>
																											</div>
																											<div class="form-group">
																												<label class="text-darkblue">Unit</label>
																												<select name="unit_id" id="unit_id" class="form-control">
																													<option value="">-- Pilih unit --</option>
																													@foreach ($unit as $value)
																														<option value="{{$value->id}}" {{$item->unit_id == $value->id ? "selected" : ''}}>{{$value->name}}</option>
																													@endforeach
																												</select>
																											</div>
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
                                    <div class="modal fade" id="modal-delete-{{$item->id}}" style="padding-right: 17px; ">
                                        <form action="{{ route('backend.dpa.destroy', $item->id) }}" method="POST" id="delete_dpa">
                                            @method('DELETE')
                                            @csrf
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"><strong> Hapus dpa </strong></h5>
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
<div class="modal fade" id="modal-lg-create" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong> Data DPA </strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('backend.dpa.store') }}" method="POST" id="submit_dpa">
                @csrf
                <div class="row">
                  <div class="col-sm-12">
                    <!-- text input -->
										<label for="informasi">Informasi DPA</label>
                    <div class="form-group">
                        <label class="text-darkblue">No DPA</label>
                        <input type="text" class="form-control" name="no_dpa" placeholder="Silahkan masukan No DPA" required>
                    </div>
                    <div class="form-group">
                      <label class="text-darkblue">Tahun</label>
                      <input type="number" class="form-control" name="tahun" value="{{date('Y')}}" placeholder="Silahkan masukan Tahun" required>
                    </div>
										<div class="form-group">
                      <label class="text-darkblue">Alokasi</label>
                      <input type="number" class="form-control" name="alokasi"placeholder="Silahkan masukan Alokasi" required>
                    </div>
										<label for="informasi">Rincian DPA</label>
										<div class="form-group">
                      <label class="text-darkblue">Urusan</label>
											<select name="urusan_id" id="urusan_id" class="form-control">
												<option value="">-- Pilih Urusan --</option>
												@foreach ($urusan as $item)
													<option value="{{$item->id}}">{{$item->name}}</option>
												@endforeach
											</select>
                    </div>
										<div class="form-group">
                      <label class="text-darkblue">Bidang</label>
											<select name="bidang_id" id="bidang_id" class="form-control">
												<option value="">-- Pilih bidang --</option>
												@foreach ($bidang as $item)
													<option value="{{$item->id}}">{{$item->name}}</option>
												@endforeach
											</select>
                    </div>
										<div class="form-group">
                      <label class="text-darkblue">Program</label>
											<select name="program_id" id="program_id" class="form-control">
												<option value="">-- Pilih program --</option>
												@foreach ($program as $item)
													<option value="{{$item->id}}">{{$item->name}}</option>
												@endforeach
											</select>
                    </div>
										<div class="form-group">
                      <label class="text-darkblue">Kegiatan</label>
											<select name="kegiatan_id" id="kegiatan_id" class="form-control">
												<option value="">-- Pilih kegiatan --</option>
												@foreach ($kegiatan as $item)
													<option value="{{$item->id}}">{{$item->title}}</option>
												@endforeach
											</select>
                    </div>
										<div class="form-group">
                      <label class="text-darkblue">Organisasi</label>
											<select name="organisasi_id" id="organisasi_id" class="form-control">
												<option value="">-- Pilih organisasi --</option>
												@foreach ($organisasi as $item)
													<option value="{{$item->id}}">{{$item->name}}</option>
												@endforeach
											</select>
                    </div>
										<div class="form-group">
                      <label class="text-darkblue">Unit</label>
											<select name="unit_id" id="unit_id" class="form-control">
												<option value="">-- Pilih unit --</option>
												@foreach ($unit as $item)
													<option value="{{$item->id}}">{{$item->name}}</option>
												@endforeach
											</select>
                    </div>
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
        $("#submit_dpa").submit();
    });
  });
</script>
@endsection
