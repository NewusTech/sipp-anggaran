@extends('layouts.main')

@section('title', 'Pengaturan Informasi Utama')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Informasi') }}</span></li>
        <li class="breadcrumb-item active">{{ __('Informasi Utama') }}</li>
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
                <!-- <div class="row">
                    <h4 class="text-darkblue"><strong> INFORMASI UTAMA </strong></h4>
                </div> -->
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Informasi Utama</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row">
                            <div class="col-12">
                                {{-- <table id="example1" class="table ">
                                    <thead>
                                    <tr>
                                        <th style="width: 25%; padding:1rem 2.25rem;">Title</th>
                                        <th style="width: 25%; padding:1rem 2.25rem;">Versi</th>
                                        <th style="width: 40%; padding:1rem 2.25rem;">Description</th>
                                        <!-- <th style="text-align: center">Aksi</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($informasi_utama as $item)
                                    <tr>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->versi}}</td>
                                        <td>{{$item->description}}</td>
                                        <!-- <td class="btn-action">
                                            <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-block btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                        </td> -->
                                    </tr>
                                    <div class="modal fade" id="modal-lg-edit-{{$item->id}}">
                                        <form action="{{ route('backend.informasi_utama.update', $item->id) }}" method="POST" id="update_informasi_utama">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"><strong> Data Informasi Utama </strong></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                            <label class="text-darkblue">Nama Informasi Utama</label>
                                                            <input type="text" class="form-control" name="title" value="{{$item->name}}" placeholder="Silahkan masukan nama Informasi Utama" required>
                                                            </div>
                                                            <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- date input -->
                                                            <div class="form-group">
                                                            <label class="text-darkblue">Tanggal Join Informasi Utama</label>
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
                                    <div class="modal fade" id="modal-delete-{{$item->id}}">
                                        <form action="{{ route('backend.informasi_utama.destroy', $item->id) }}" method="POST" id="delete_informasi_utama">
                                            @method('DELETE')
                                            @csrf
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title"><strong> Hapus Informasi Utama </strong></h5>
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
                                </table> --}}
															<div class="card">
																<div class="card-header"  style="background-color: #f5faff; border-radius: 0.5rem;">
																	<strong>Total File Size : 0.0 MB</strong>
																</div>
																<div class="card-body">
																	<div class="row">
																		<div class="col-12">
																			<div id="accordion">
																				<span class="text-darkblue">Versiaon Terbaru 2.0.0</span>
																				<div class="card-button-right">
																					<a href="#" id="heading-1" class="text-darkblue" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapseOne">Lihat Daftar Paket & Anggaran</a>
																				</div>
																				<div id="collapse-1" class="collapse" aria-labelledby="heading-1" data-parent="#accordion">
																					<div class="row">
																						<div class="col-12">
																							<div class="card">
																								<div class="card-body table-responsive p-3 fs-10" style="height: 100% border: 1px solid #f5faff">
																									1. Bug fixes <br>
																									2. Perubahan tampilan.<br>
																									3. Penambahan GIS pada halaman dashboard<br>
																									4. Diagram keungan<br>
																									5. Grafik akumulasi realisasi keuangan setiap bulan<br>
																									6. Fitur pengarsipan kegiatan<br>
																									7. Halaman Pengaturan wilayah<br>
																									8. Perhitungan sisa waktu pekerjaan 9. Fitur cetak rekapitulasi laporan<br>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<div class="modal fade" id="modal-lg-create">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong> Data Informasi Utama </strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('backend.informasi_utama.store') }}" method="POST" id="submit_informasi_utama">
                @csrf
                <div class="row">
                  <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                      <label class="text-darkblue">Nama Informasi Utama</label>
                      <input type="text" class="form-control" name="title" placeholder="Silahkan masukan nama Informasi Utama" required>
                    </div>
                    <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <!-- date input -->
                    <div class="form-group">
                      <label class="text-darkblue">Tanggal Join Informasi Utama</label>
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
<!-- <script>
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
    $("#example1_filter").append('<button id="addInformasiUtama" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah Informasi Utama</button>');
    $("#example1_filter").addClass('btn-action-right');
    $("#example1_filter label").addClass('search');
    $(".search input").before( `
        <span class="fa fa-search"></span>
    `);
    $(".search input").attr("placeholder", "Ketik Kata Kunci");
    $(".search input").attr("style", "width: 20rem;");
    $("#btn_submit").on("click", function (){
        $("#submit_informasi_utama").submit();
    });
  });
</script> -->
@endsection
