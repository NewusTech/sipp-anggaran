@extends('layouts.main')

@section('title', 'Petunjuk')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Petunjuk') }}</li>
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
                    @can('tambah petunjuk')
                    <button class="btn btn-primary btn-sm btn-add text-white" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah Petunjuk</button>
                    @endcan
                    <button class="btn btn-primary btn-sm btn-add text-white" data-toggle="modal" data-target="#modal-lg-upload"><i class="fas fa-plus"></i>Upload</button>
                </div>
            </div>

            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Petunjuk</a>
                </li>
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-12">
                                    <div id="accordion">
                                        @foreach ($petunjuk as $item)
                                        <div class="card">
                                            <div id="heading-{{$item->id}}" class="card-header btn btn-link" data-toggle="collapse" data-target="#collapse-{{$item->id}}" aria-expanded="true" aria-controls="collapseOne" style="background-color: #f5faff; border-radius: 0.5rem;">
                                                <div class="card-table">
                                                    <div class="taf text-darkblue">
                                                        <strong>{{$item->title}}</strong>
                                                    </div>
                                                    <div class="btn-table-cell tar">
                                                        @can('ubah petunjuk')
                                                        <button class="btn btn-warning btn-sm text-white rounded-lg" data-toggle="modal" data-target="#modal-lg-edit-{{$item->id}}"><i class="fas fa-edit"></i></button>
                                                        @endcan
                                                        @can('hapus petunjuk')
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$item->id}}"><i class="fas fa-trash"></i></button>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="collapse-{{$item->id}}" class="collapse" aria-labelledby="heading-{{$item->id}}" data-parent="#accordion">
                                                <div class="card-body table-responsive p-3" style="height: 100%">
                                                    {!! $item->detail !!}
                                                </div>
                                            </div>
                                        </div>

                                        {{--modal edit--}}
                                        <div class="modal fade" id="modal-lg-edit-{{$item->id}}" style="padding-right: 17px; ">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><strong> Edit Petunjuk </strong></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('backend.petunjuk.update', $item) }}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="text-darkblue">Judul</label>
                                                                        <input type="text" class="form-control" value="{{$item->title}}" name="title" placeholder="Silahkan masukan judul petunjuk" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="text-darkblue">Detail</label>
                                                                        <textarea class="summernote_edit" rows="7" name="detail">
                                                                                       {!! $item->detail !!}
                                                                                    </textarea>
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
                                        {{-- modal hapus --}}
                                        <div class="modal fade" id="modal-delete-{{$item->id}}" style="padding-right: 17px; ">
                                            <form action="{{ route('backend.petunjuk.destroy', $item) }}" method="POST" id="delete">
                                                @method('DELETE')
                                                @csrf
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><strong> Hapus Data Petunjuk </strong></h5>
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
                                        </div>
                                        @endforeach
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
<div class="modal fade" id="modal-lg-create" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Petunjuk </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.petunjuk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="text-darkblue">Judul</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul petunjuk" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Detail</label>
                                <textarea id="summernote" rows="7" name="detail">
                                        Place <em>some</em> <u>text</u> <strong>here</strong>
                                    </textarea>
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

<div class="modal fade" id="modal-lg-upload" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Upload Petunjuk </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.petunjuk.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="text-darkblue">Judul</label>
                                <input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul petunjuk" required>
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
@endsection

@section('js')
<script src="{{ asset('admin') }}/plugins/summernote/summernote-bs4.min.js"></script>
<script>
    $(function() {
        $('#summernote').summernote({
            height: 250
        })
        $('.summernote_edit').summernote({
            height: 250
        })
    })
</script>
@endsection
