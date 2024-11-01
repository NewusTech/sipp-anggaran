@extends('layouts.main')

@section('title', 'Pengaturan Penyedia Jasa')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Kegiatan') }}</span></li>
        <li class="breadcrumb-item active">{{ __('Penyedia Jasa') }}</li>
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
                    @can("tambah penyedia jasa")
                    <button id="addPenyediaJasa" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah</button>
                    @endcan
                </div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> PENYEDIA JASA </strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Daftar Penyedia Jasa</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row">
                            <div class="col-12">
                                <div style="overflow-x: auto;">
                                    <table id="example1" class="table" style="min-width: 800px;"> <!-- Set a minimum width as needed -->
                                        <thead>
                                            <tr>
                                                <th style="padding:1rem 2.25rem;">Nama Kontraktor</th>
                                                <th style="padding:1rem 2.25rem;">Telepon</th>
                                                <th style="padding:1rem 2.25rem;">Email</th>
                                                <th style="padding:1rem 2.25rem;">Tanggal Bergabung</th>
                                                <th style="text-align: center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penyedia_jasa as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->telepon}}</td>
                                                <td>{{$item->email}}</td>
                                                <td><span style="color: red;">{{ \Carbon\Carbon::parse($item->join_date)->format('d-m-Y') }}</span> ({{ \Carbon\Carbon::parse($item->join_date)->format('H:i') }})</td>
                                                <td class="btn-action">
                                                    @can('ubah penyedia jasa')
                                                    <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                    @endcan
                                                    @can('hapus penyedia jasa')
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                    @endcan
                                                </td>
                                            </tr>
                                            <!-- Modals for Edit and Delete -->
                                            <!-- Existing modal code here... -->
                                            @endforeach
                                        </tbody>
                                    </table>
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
<div class="modal fade" id="modal-lg-create" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Data Penyedia Jasa </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.penyedia_jasa.store') }}" method="POST" id="submit_penyedia_jasa">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Nama Kontraktor</label>
                                <input type="text" class="form-control" name="name" placeholder="Silahkan masukan Nama Kontraktor" required>
                            </div>
                            <span class="text-gray">*Tidak boleh mengandung karakter khusus</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Telepon</label>
                                <input type="text" class="form-control" name="telepon" placeholder="Silahkan masukan Telepon" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Silahkan masukan Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- date input -->
                            <div class="form-group">
                                <label class="text-darkblue">Tanggal Bergabung</label>
                                <input type="datetime-local" class="form-control" name="join_date" placeholder="Silahkan masukan tanggal join Penyedia Jasa" required>
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
    $(function() {
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
        $(".search input").before(`
        <span class="fa fa-search"></span>
    `);
        $(".search input").attr("placeholder", "Ketik Kata Kunci");
        $("#btn_submit").on("click", function() {
            $("#submit_penyedia_jasa").submit();
        });
    });
</script>
@endsection