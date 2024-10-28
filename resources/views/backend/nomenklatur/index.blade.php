@extends('layouts.main')

@section('title', 'Pengaturan Nomenklatur')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Pengaturan') }}</span></li>
        <li class="breadcrumb-item active">{{ __('Nomenklatur') }}</li>
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
                {{-- <button type="button" class="btn btn-warning btn-sm"  style="color: white;" ><i class="fa fa-edit"></i> Edit</button> --}}
                @if ($nomenklatur)
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus-nomenklatur"><i class="fas fa-trash"></i> Hapus</button>
                @endif
              </div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> DATA NOMENKLATUR </strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Nomenklatur</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row">
                            <div class="col-12">
                                <table id="example1" class="table ">
                                    <thead>
                                    <div class="modal-body">
                                      <form action="{{ route('backend.nomenklatur.store') }}" method="POST">
                                          @csrf
                                          <input type="hidden" value="{{$nomenklatur->id ?? ''}}" id="id" name="id">
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <!-- text input -->
                                              <div class="form-group">
                                                <label class="text-darkblue">Set PPTK</label>
                                                <input type="text" class="form-control" id="pptk" name="pptk" value="{{$nomenklatur->pptk ?? ''}}" placeholder="Silahkan masukkan PPTK" required>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <!-- text input -->
                                              <div class="form-group">
                                                <label class="text-darkblue">Set PPK</label>
                                                <input type="text" class="form-control" id="ppk" name="ppk" value="{{$nomenklatur->ppk ?? ''}}" placeholder="Silahkan masukkan PPK" required>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer justify-content-end">
                                              <button type="submit" class="btn btn-primary">Simpan</button>
                                          </div>
                                      </form>
                                    </div>
                                    </thead>
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
<div class="modal fade" id="modal-hapus-nomenklatur" >
  <form action="{{ route('backend.nomenklatur.destroy', $nomenklatur->id ?? '-') }}" method="POST">
      @method('DELETE')
      @csrf
      <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title"><strong> Hapus Nomenklatur </strong></h5>
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
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
@endsection
