@extends('layouts.main')

@section('title', 'Pengaturan Penanggung Jawab')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
            <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}"
                    class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Pengaturan') }}</span></li>
            <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Pengaturan Penanggung Jawab') }}</span>
            </li>
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
    @elseif (session()->has('error'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 flex-md-row flex-column justify-content-md-between">
                        <div class="row mb-0">
                            <h4 class="text-darkblue"><strong> DATA PENANGGUNG JAWAB </strong></h4>
                        </div>
                        <div class="ml-2 mb-2 card-action-right d-flex justify-content-end ">
                            <button id="addPenanggungJawab" class="btn btn-primary btn-sm btn-add" data-toggle="modal"
                                data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah Penanggung Jawab</button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                                href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                                aria-selected="true">Daftar Penanggung Jawab</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
                            aria-labelledby="custom-content-below-home-tab">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table id="example1" class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama Pengawas</th>
                                                <th>Email</th>
                                                <th>No Telepon</th>
                                                <th>Nama Admin</th>
                                                <th style="text-align: end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penanggungJawab as $item)
                                                <tr>
                                                    <td
                                                        style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">
                                                        {{ $item->pptk_name }}</td>
                                                    <td
                                                        style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">
                                                        {{ $item->pptk_email }}</td>
                                                    <td
                                                        style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">
                                                        {{ $item->pptk_telpon }}</td>
                                                    <td
                                                        style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;">
                                                        {{ $item->ppk_name }}</td>
                                                    <td class="btn-action">
                                                        <button type="button" style="color: white;"
                                                            class="btn btn-warning btn-sm" data-toggle="modal"
                                                            data-target="#modal-lg-edit-{{ $item->id }}"><i
                                                                class="fas fa-edit"></i> </button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal-delete-{{ $item->id }}"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @include(
                                                    'backend.penanggung-jawab._modal_penanggung_jawab',
                                                    ['action' => 'edit']
                                                )
                                                @include(
                                                    'backend.penanggung-jawab._modal_penanggung_jawab',
                                                    ['action' => 'delete']
                                                )
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

    @include('backend.penanggung-jawab._modal_penanggung_jawab', ['action' => 'add'])
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
                $("#submit_bidang").submit();
            });
        });
    </script>
@endsection
