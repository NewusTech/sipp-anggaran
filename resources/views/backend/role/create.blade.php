@extends('layouts.main')

@section('title', 'Role')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Role') }}</span></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Tambah Role') }}</span></li>
    </ol>
</div>
@endsection

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{ __('Form tambah role') }}
            </div>
            <div class="card-body">
                <div class="text-right">
                    <a href="{{ route('backend.roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>
                        {{ __('Kembali') }}
                    </a>
                </div>
                <form action="{{ route('backend.roles.store') }}" method="POST">
                    @csrf
                    @include('backend.role._form')
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            {{ __('Simpan') }}
                        </button>
                        <a href="{{ route('backend.roles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('Batal') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin') }}/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    });
</script>
@endsection
