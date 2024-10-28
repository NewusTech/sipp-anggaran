@extends('layouts.main')

@section('title', 'DPA')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item "><a href="{{ route('backend.dpa.index') }}" class="text-lightgray fs-14">{{ __('DPA') }}</a></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Detail DPA') }}</span></li>
    </ol>
</div>
@endsection
@php

@endphp
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
@if (session()->has('errors'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('errors') }}
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card card-default overflow-auto">
            <div class="card-header">
                <h4 class="text-darkblue"><strong> DATA DPA </strong></h4>
            </div>
            <div class="card-body p-0">
                <div class="bs-stepper ">
                    <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step" data-target="#informasi-dpa">
                            <button type="button" class="step-trigger" role="tab" aria-controls="informasi-dpa" id="informasi-dpa-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Informasi DPA</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step  {{session('step') == 'sub_kegiatan'? 'active' : ''}}" data-target="#sub-kegiatan">
                            <button type="button" class="step-trigger" role="tab" aria-controls="sub-kegiatan" id="sub-kegiatan-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Sub Kegiatan</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step  {{session('step') == 'pengambilan'? 'active' : ''}}" data-target="#rencana-penarikan">
                            <button type="button" class="step-trigger" role="tab" aria-controls="rencana-penarikan" id="rencana-penarikan-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Rencana Penarikan</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step  {{session('step') == 'pengguna_anggaran'? 'active' : ''}}" data-target="#pengguna-anggaran">
                            <button type="button" class="step-trigger" role="tab" aria-controls="pengguna-anggaran" id="pengguna-anggaran-trigger">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Pengguna anggaran</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step  {{session('step') == 'tanda_tangan'? 'active' : ''}}" data-target="#tanda-tangan">
                            <button type="button" class="step-trigger" role="tab" aria-controls="tanda-tangan" id="tanda-tangan-trigger">
                                <span class="bs-stepper-circle">5</span>
                                <span class="bs-stepper-label">Tanda Tangan</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="informasi-dpa" class="content" role="tabpanel" aria-labelledby="informasi-dpa-trigger">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2 text-bold">
                                                    <p>DPA : {{($dpa->no_dpa)}}</p>
                                                    <p>Tahun : {{($dpa->tahun)}}</p>
                                                </div>
                                                <div class="right">
                                                    <p>Total Alokasi: Rp {{number_format($dpa->alokasi)}}</p>
                                                    <p>Ter Alokasi: Rp {{number_format($dpa->realisasi)}}</p>
                                                    <p>Sisa Alokasi: Rp {{number_format($dpa->alokasi - $dpa->realisasi)}}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2">
                                                    <p class="text-xs text-bold">- Urusan: <span class="italic">{{$dpa->kode_urusan}} | {{$dpa->urusan}}</span></p>
                                                    <p class="text-xs text-bold ml-2">- Bidang: <span class="italic">{{$dpa->kode_bidang}} | {{$dpa->bidang}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Program: <span class="italic">{{$dpa->kode_program}} | {{$dpa->program}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Kegiatan: <span class="italic">{{$dpa->no_kegiatan}} | {{$dpa->kegiatan}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Organisasi: <span class="italic">{{$dpa->kode_organisasi}} | {{$dpa->organisasi}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Unit: <span class="italic">{{$dpa->kode_unit}} | {{$dpa->unit}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary" onclick="stepper.next()"> Selanjutnya <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sub-kegiatan" class="content  {{session('step') == 'sub_kegiatan'? 'active dstepper-block' : ''}}" role="tabpanel" aria-labelledby="sub-kegiatan-trigger">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2 text-bold">
                                                    <p>DPA : {{($dpa->no_dpa)}}</p>
                                                    <p>Tahun : {{($dpa->tahun)}}</p>
                                                </div>
                                                <div class="right">
                                                    <p>Total Alokasi: Rp {{number_format($dpa->alokasi)}}</p>
                                                    <p>Ter Alokasi: Rp {{number_format($dpa->realisasi)}}</p>
                                                    <p>Sisa Alokasi: Rp {{number_format($dpa->alokasi - $dpa->realisasi)}}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2">
                                                    <p class="text-xs text-bold">- Urusan: <span class="italic">{{$dpa->kode_urusan}} | {{$dpa->urusan}}</span></p>
                                                    <p class="text-xs text-bold ml-2">- Bidang: <span class="italic">{{$dpa->kode_bidang}} | {{$dpa->bidang}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Program: <span class="italic">{{$dpa->kode_program}} | {{$dpa->program}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Kegiatan: <span class="italic">{{$dpa->no_rek}} | {{$dpa->kegiatan}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Organisasi: <span class="italic">{{$dpa->kode_organisasi}} | {{$dpa->organisasi}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Unit: <span class="italic">{{$dpa->kode_unit}} | {{$dpa->unit}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action-right">
                                        <button id="addsub" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="row">
                                        <h4 class="text-darkblue"><strong> Sub Kegiatan </strong></h4>
                                    </div>
                                    <div class="overflow-auto">
                                        <table id="example1" class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="padding:1rem 2.25rem;">SUB KEGIATAN / SUMBER DANA / LOKASI</th>
                                                    <th>Total Pagu</th>
                                                    <th style="text-align: center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sub_kegiatan as $item)
                                                <tr>
                                                    <td>
                                                        <p class="text-xs text-bold">- <span class="italic">{{$item->no_detail_kegiatan}} | {{$item->detail_kegiatan}}</span></p>
                                                        <p class="text-xs text-bold ml-2">- <span class="italic">{{$item->sumber_dana}}</span></p>
                                                        <p class="text-xs text-bold ml-4">- <span class="italic">{{$item->lokasi}}</span></p>
                                                    </td>
                                                    <td>Rp{{number_format($item->total_pagu)}}</td>
                                                    <td class="btn-action">
                                                        <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modal-lg-edit-{{$item->id}}" >
                                                    <form action="{{ route('backend.sub_kegiatan.update', $item->id) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Data Sub Kegiatan </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <input type="hidden" name="kegiatan_id" value="{{$dpa->kegiatan_id}}">
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Sub Kegiatan</label>
                                                                                <select name="detail_kegiatan_id" id="detail_kegiatan_id" class="form-control" required>
                                                                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                                                                    @foreach ($details as $value)
                                                                                    <option value="{{$value->id}}" {{$item->detail_kegiatan_id == $value->id? "selected" : "" }}>{{$value->title}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Sumber Dana</label>
                                                                                <select name="sumber_dana_id" id="sumber_dana_id" class="form-control" required>
                                                                                    <option value="">-- Pilih Sumber Dana --</option>
                                                                                    @foreach ($sumber_dana as $value)
                                                                                    <option value="{{$value->id}}" {{$item->sumber_dana_id == $value->id? "selected" : "" }}>{{$value->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Waktu Pelaksanaan</label>
                                                                                <input type="date" name="tanggal" value="{{$item->pagu ? $item->pagu->tanggal : ''}}" class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Keterangan</label>
                                                                                <input type="text" name="keterangan" value="{{$item->pagu ? $item->pagu->keterangan : ''}}" class="form-control" required>
                                                                            </div>
                                                                            <hr>
                                                                            <label for="pagu">Pagu</label>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Belanja Operasi</label>
                                                                                <input type="number" name="belanja_operasi" value="{{round($item->pagu ? $item->pagu->belanja_operasi : 0)}}" class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Belanja Modal</label>
                                                                                <input type="number" name="belanja_modal" value="{{round($item->pagu ? $item->pagu->belanja_modal : 0)}}" class="form-control" required>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Belanja Tidak Terduga</label>
                                                                                <input type="number" name="belanja_tak_terduga" value="{{round($item->pagu ? $item->pagu->belanja_tak_terduga : 0)}}" class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Belanja Transfer</label>
                                                                                <input type="number" name="belanja_transfer" value="{{round($item->pagu ? $item->pagu->belanja_transfer : 0)}}" class="form-control" required>
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
                                                <div class="modal fade" id="modal-delete-{{$item->id}}" >
                                                    <form action="{{ route('backend.sub_kegiatan.destroy', $item->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Hapus Sub Kegiatan </strong></h5>
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
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-default" onclick="stepper.previous()"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                                            <button class="btn btn-primary" onclick="stepper.next()"> Selanjutnya <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="rencana-penarikan" class="content {{session('step') == 'pengambilan'? 'active dstepper-block' : ''}}" role="tabpanel" aria-labelledby="rencana-penarikan-trigger">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2 text-bold">
                                                    <p>DPA : {{($dpa->no_dpa)}}</p>
                                                    <p>Tahun : {{($dpa->tahun)}}</p>
                                                </div>
                                                <div class="right">
                                                    <p>Total Alokasi: Rp {{number_format($dpa->alokasi)}}</p>
                                                    <p>Ter Alokasi: Rp {{number_format($dpa->realisasi)}}</p>
                                                    <p>Sisa Alokasi: Rp {{number_format($dpa->alokasi - $dpa->realisasi)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <div class="status-map">
                                            <dl>
                                                <dt style="margin-bottom: 5pt;">Belanja Operasi</dt>
                                                <dd>Alokasi : Rp {{number_format($totalbelanjaOperasi)}}</dd>
                                                <dd>Terealisasi : Rp {{number_format($totalOperasi)}}</dd>
                                                <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaOperasi - $totalOperasi)}}</dd>
                                            </dl>
                                        </div>
                                        <div class="status-map">
                                            <dl>
                                                <dt style="margin-bottom: 5pt;">Belanja Modal</dt>
                                                <dd>Alokasi : Rp {{number_format($totalbelanjaModal)}}</dd>
                                                <dd>Terealisasi : Rp {{number_format($totalModal)}}</dd>
                                                <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaModal - $totalModal)}}</dd>
                                            </dl>
                                        </div>
                                        <div class="status-map">
                                            <dl>
                                                <dt style="margin-bottom: 5pt;">Belanja Tidak Terduga</dt>
                                                <dd>Alokasi : Rp {{number_format($totalbelanjaTakTerduga)}}</dd>
                                                <dd>Terealisasi : Rp {{number_format($totalTakTerduga)}}</dd>
                                                <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaTakTerduga - $totalTakTerduga)}}</dd>
                                            </dl>
                                        </div>
                                        <div class="status-map">
                                            <dl>
                                                <dt style="margin-bottom: 5pt;">Belanja Transfer</dt>
                                                <dd>Alokasi : Rp {{number_format($totalbelanjaTransfer)}}</dd>
                                                <dd>Terealisasi : Rp {{number_format($totalTransfer)}}</dd>
                                                <dd>Sisa Alokasi : Rp {{number_format($totalbelanjaTransfer - $totalTransfer)}}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-action-right">
                                                <button id="addsub" class="btn btn-warning btn-sm btn-add text-white" data-toggle="modal" data-target="#modal-lg-pengambilan"><i class="fas fa-edit"></i> Input Penarikan</button>
                                            </div>
                                            <div class="row">
                                                <h4 class="text-darkblue"><strong> History Rencana Pengambilan </strong></h4>
                                            </div>
                                            <div class="overflow-auto">
                                                <table class="table" style="width:100%;" id="pengambilan">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-darkblue">No</th>
                                                            <th class="text-darkblue">Bulan</th>
                                                            <th class="text-darkblue">Belanja Operasi</th>
                                                            <th class="text-darkblue">Belanja Modal</th>
                                                            <th class="text-darkblue">Belanja Tidak Terduga</th>
                                                            <th class="text-darkblue">Belanja Transfer</th>
                                                            <th class="text-darkblue">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pengambilan as $key => $item)
                                                        <tr>
                                                            <td>{{$key+1}}</td>
                                                            <td>{{ucfirst($item->bulan)}}</td>
                                                            <td>Rp.{{number_format($item->belanja_operasi)}}</td>
                                                            <td>Rp.{{number_format($item->belanja_modal)}}</td>
                                                            <td>Rp.{{number_format($item->belanja_tak_terduga)}}</td>
                                                            <td>Rp.{{number_format($item->belanja_transfer)}}</td>
                                                            <td>{{$item->keterangan}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-default" onclick="stepper.previous()"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                                            <button class="btn btn-primary" onclick="stepper.next()"> Selanjutnya <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pengguna-anggaran" class="content {{session('step') == 'pengguna_anggaran'? 'active dstepper-block' : ''}}" role="tabpanel" aria-labelledby="pengguna-anggaran-trigger">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2 text-bold">
                                                    <p>DPA : {{($dpa->no_dpa)}}</p>
                                                    <p>Tahun : {{($dpa->tahun)}}</p>
                                                </div>
                                                <div class="right">
                                                    <p>Total Alokasi: Rp {{number_format($dpa->alokasi)}}</p>
                                                    <p>Ter Alokasi: Rp {{number_format($dpa->realisasi)}}</p>
                                                    <p>Sisa Alokasi: Rp {{number_format($dpa->alokasi - $dpa->realisasi)}}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2">
                                                    <p class="text-xs text-bold">- Urusan: <span class="italic">{{$dpa->kode_urusan}} | {{$dpa->urusan}}</span></p>
                                                    <p class="text-xs text-bold ml-2">- Bidang: <span class="italic">{{$dpa->kode_bidang}} | {{$dpa->bidang}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Program: <span class="italic">{{$dpa->kode_program}} | {{$dpa->program}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Kegiatan: <span class="italic">{{$dpa->no_kegiatan}} | {{$dpa->kegiatan}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Organisasi: <span class="italic">{{$dpa->kode_organisasi}} | {{$dpa->organisasi}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Unit: <span class="italic">{{$dpa->kode_unit}} | {{$dpa->unit}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action-right">
                                        <button id="addPengguna" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create-pengguna"><i class="fas fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="row">
                                        <h4 class="text-darkblue"><strong> Pengguna Anggaran </strong></h4>
                                    </div>
                                    <div class="overflow-auto">
                                        <table id="pengguna_anggaran" class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="padding:1rem 2.25rem;">Nama</th>
                                                    <th>NIP</th>
                                                    <th>Jabatan</th>
                                                    <th style="text-align: center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengguna as $item)
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->nip}}</td>
                                                    <td>{{$item->jabatan}}</td>
                                                    <td class="btn-action">
                                                        <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-pengguna-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-pengguna-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modal-lg-edit-pengguna-{{$item->id}}" >
                                                    <form action="{{ route('backend.pengguna_anggaran.update', $item->id) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Data Pengguana Anggaran </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <input type="hidden" name="dpa_id" value="{{$dpa->id}}">
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nama</label>
                                                                                <input type="text" name="name" value="{{$item->name}}" class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">NIP</label>
                                                                                <input type="text" name="nip" value="{{$item->nip}}" class="form-control" required>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Jabatan</label>
                                                                                <input type="text" name="jabatan" value="{{$item->jabatan}}" class="form-control" required>
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
                                                <div class="modal fade" id="modal-delete-pengguna-{{$item->id}}" >
                                                    <form action="{{ route('backend.pengguna_anggaran.destroy', $item->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Hapus Pengguna Anggaran </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <input type="hidden" name="dpa_id" value="{{$dpa->id}}">
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
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-default" onclick="stepper.previous()"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                                            <button class="btn btn-primary" onclick="stepper.next()"> Selanjutnya <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tanda-tangan" class="content {{session('step') == 'tanda_tangan'? 'active dstepper-block' : ''}}" role="tabpanel" aria-labelledby="tanda-tangan-trigger">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2 text-bold">
                                                    <p>DPA : {{($dpa->no_dpa)}}</p>
                                                    <p>Tahun : {{($dpa->tahun)}}</p>
                                                </div>
                                                <div class="right">
                                                    <p>Total Alokasi: Rp {{number_format($dpa->alokasi)}}</p>
                                                    <p>Ter Alokasi: Rp {{number_format($dpa->realisasi)}}</p>
                                                    <p>Sisa Alokasi: Rp {{number_format($dpa->alokasi - $dpa->realisasi)}}</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="flex justify-content-between ">
                                                <div class="flex flex-col p-2">
                                                    <p class="text-xs text-bold">- Urusan: <span class="italic">{{$dpa->kode_urusan}} | {{$dpa->urusan}}</span></p>
                                                    <p class="text-xs text-bold ml-2">- Bidang: <span class="italic">{{$dpa->kode_bidang}} | {{$dpa->bidang}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Program: <span class="italic">{{$dpa->kode_program}} | {{$dpa->program}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Kegiatan: <span class="italic">{{$dpa->no_kegiatan}} | {{$dpa->kegiatan}}</span></p>
                                                    <p class="text-xs text-bold ml-4">- Organisasi: <span class="italic">{{$dpa->kode_organisasi}} | {{$dpa->organisasi}}</span></p>
                                                    <p class="text-xs text-bold ml-5">- Unit: <span class="italic">{{$dpa->kode_unit}} | {{$dpa->unit}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-action-right">
                                        <button id="addTtd" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create-ttd"><i class="fas fa-plus"></i> Tambah</button>
                                    </div>
                                    <div class="row">
                                        <h4 class="text-darkblue"><strong> Tanda Tangan </strong></h4>
                                    </div>
                                    <div class="overflow-auto">
                                        <table id="tanda_tangan" class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="padding:1rem 2.25rem;">Nama</th>
                                                    <th>NIP</th>
                                                    <th>Jabatan</th>
                                                    <th style="text-align: center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ttd as $item)
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->nip}}</td>
                                                    <td>{{$item->jabatan}}</td>
                                                    <td class="btn-action">
                                                        <button type="button" style="color: white;" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-ttd-{{$item->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-ttd-{{$item->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="modal-lg-edit-ttd-{{$item->id}}" >
                                                    <form action="{{ route('backend.tanda_tangan.update', $item->id) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Data Tanda Tangan </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <!-- text input -->
                                                                            <input type="hidden" name="dpa_id" value="{{$dpa->id}}">
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nama</label>
                                                                                <input type="text" name="name" value="{{$item->name}}" class="form-control" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">NIP</label>
                                                                                <input type="text" name="nip" value="{{$item->nip}}" class="form-control" required>

                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Jabatan</label>
                                                                                <input type="text" name="jabatan" value="{{$item->jabatan}}" class="form-control" required>
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
                                                <div class="modal fade" id="modal-delete-ttd-{{$item->id}}" >
                                                    <form action="{{ route('backend.tanda_tangan.destroy', $item->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Hapus Tanda Tangan </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <input type="hidden" name="dpa_id" value="{{$dpa->id}}">
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
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-default" onclick="stepper.previous()"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                                            <a class="btn btn-success" href="{{route('backend.dpa.result', $dpa->id)}}"> Selesai <i class="fas fa-arrow-right"></i></a>
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
<div class="modal fade" id="modal-lg-create" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Sub Kegiatan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.sub_kegiatan.store', $dpa->id) }}" method="POST" id="submit_sub">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <input type="hidden" name="kegiatan_id" value="{{$dpa->kegiatan_id}}">
                            <div class="form-group">
                                <label class="text-darkblue">Sub Kegiatan</label>
                                <select name="detail_kegiatan_id" id="detail_kegiatan_id" class="form-control" required>
                                    <option value="">-- Pilih Sub Kegiatan --</option>
                                    @foreach ($details as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Sumber Dana</label>
                                <select name="sumber_dana_id" id="sumber_dana_id" class="form-control" required>
                                    <option value="">-- Pilih Sumber Dana --</option>
                                    @foreach ($sumber_dana as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Waktu Pelaksanaan</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control" required>
                            </div>
                            <hr>
                            <label for="pagu">Pagu</label>
                            <div class="form-group">
                                <label class="text-darkblue">Belanja Operasi</label>
                                <input type="number" name="belanja_operasi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Belanja Modal</label>
                                <input type="number" name="belanja_modal" class="form-control" required>

                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Belanja Tidak Terduga</label>
                                <input type="number" name="belanja_tak_terduga" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Belanja Transfer</label>
                                <input type="number" name="belanja_transfer" class="form-control" required>
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

<div class="modal fade" id="modal-lg-create-pengguna" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Pengguna Anggaran </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.pengguna_anggaran.store') }}" method="POST" id="submit_sub_pengguna_anggaran">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <input type="hidden" name="dpa_id" value="{{$dpa->id}}">
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">NIP</label>
                                <input type="text" name="nip" class="form-control" required>

                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" id="btn_submit_pengguna_anggaran" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-lg-create-ttd" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Tanda Tangan </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.tanda_tangan.store') }}" method="POST" id="submit_sub_tanda_tangan">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- text input -->
                            <input type="hidden" name="dpa_id" value="{{$dpa->id}}">
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">NIP</label>
                                <input type="text" name="nip" class="form-control" required>

                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" id="btn_submit_tanda_tangan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@include('backend.dpa._modal_pengambilan')
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('admin') }}/plugins/bs-stepper/js/bs-stepper.min.js"></script>
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
        $("#btn_submit").on("click", function() {
            $("#submit_sub").submit();
        });
        $("#pengambilan").DataTable({
            "responsive": true,
            "autoWidth": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "collapsed": true,
        });
        $("#pengambilan_filter label").addClass('search');
        $(".search input").before(`
        <span class="fa fa-search"></span>
    `);
        $("#btn_submit_pengambilan").on("click", function() {
            $("#submit_sub_pengambilan").submit();
        });
        $("#pengguna_anggaran").DataTable({
            "responsive": true,
            "autoWidth": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "collapsed": true,
        });
        $("#pengguna_anggaran_filter label").addClass('search');
        $(".search input").before(`
        <span class="fa fa-search"></span>
    `);
        $("#btn_submit_pengguna_anggaran").on("click", function() {
            $("#submit_sub_pengguna_anggaran").submit();
        });
        $("#tanda_tangan").DataTable({
            "responsive": true,
            "autoWidth": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "collapsed": true,
        });
        $("#tanda_tangan_filter label").addClass('search');
        $(".search input").before(`
        <span class="fa fa-search"></span>
    `);
        $(".search input").attr("placeholder", "Ketik Kata Kunci");
        $("#btn_submit_tanda_tangan").on("click", function() {
            $("#submit_sub_tanda_tangan").submit();
        });
    });
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
</script>
<script>
    function getPengambilanByDpa(dpa_id, bulan) {
        let token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: `{{route('backend.pengambilan.get.dpa')}}`,
            type: "GET",
            cache: false,
            data: {
                "dpa_id": dpa_id,
                "bulan": bulan,
                "_token": token
            },
            success: function(response) {
                if (response.success) {
                    if (response.data) {
                        console.log(response.data);
                        $('#belanja_operasi').val(parseInt(response.data.belanja_operasi, 10));
                        $('#belanja_modal').val(parseInt(response.data.belanja_modal, 10));
                        $('#belanja_tak_terduga').val(parseInt(response.data.belanja_tak_terduga, 10));
                        $('#belanja_transfer').val(parseInt(response.data.belanja_transfer, 10));
                        $('#keterangan').val(response.data.keterangan);
                    }
                } else {
                    console.log(response.success);
                }
            },
            error: function(response) {
                console.log('error');
            }
        });
    }
</script>
@endsection
