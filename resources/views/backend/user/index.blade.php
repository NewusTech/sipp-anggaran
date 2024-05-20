@extends('layouts.main')

@section('title', 'Pengelolaan User')

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
        <li class="breadcrumb-item active">{{ __('Pengelolaan User') }}</li>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
							<div class="card-action-right">
								<button id="addUser" class="btn btn-primary btn-sm btn-add" data-toggle="modal" data-target="#modal-lg-create"><i class="fas fa-plus"></i> Tambah User</button>
							</div>
                <div class="row">
                    <h4 class="text-darkblue"><strong> DATA USER </strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Daftar User</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                        <div class="row">
                            <div class="col-12">
                                <table id="example1" class="table ">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Username') }}</th>
                                        <th>{{ __('Nama') }}</th>
                                        <th>{{ __('NIP') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Telepon') }}</th>
                                        <th>{{ __('Bidang') }}</th>
                                        <th>{{ __('Level') }}</th>
                                        <th style="text-align: center">{{ __('Aksi') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($users as $user)
                                        @if($user->roles[0]->id >= auth()->user()->roles[0]->id && ($user->bidang_id == auth()->user()->bidang_id || auth()->user()->roles[0]->name == 'Super Admin' || auth()->user()->roles[0]->name == 'Kepala Dinas'))
                                            <tr>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->nip }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone_number }}</td>
                                                <td class="text-wrap">{{ $user->bidang->name ?? '-' }}</td>
                                                <td>
                                                    @foreach ($user->roles as $user_role)
                                                        {{ $user_role->name }}
                                                    @endforeach
                                                </td>
                                                <td class="btn-action" style="width: 260px;">
                                                    @if($user->roles[0]->name != 'Super Admin')
                                                        <button type="button" class="btn btn-block btn-light btn-sm text-black-50" data-toggle="modal" data-target="#modal-lg-reset-{{$user->id}}"><i class="fas fa-cog"></i> Reset</button>
                                                        <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$user->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                        @if(auth()->user()->id != $user->id)
                                                            <button type="button" class="btn btn-block btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete-{{$user->id}}"><i class="fas fa-trash"></i> Hapus</button>
                                                        @endif
                                                    @elseif(auth()->user()->roles[0]->name == $user->roles[0]->name)
                                                        <button type="button" class="btn btn-block btn-light btn-sm text-black-50" data-toggle="modal" data-target="#modal-lg-reset-{{$user->id}}"><i class="fas fa-cog"></i> Reset</button>
                                                        <button type="button" style="color: white;" class="btn btn-block btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-edit-{{$user->id}}"><i class="fas fa-edit"></i> Edit</button>
                                                    @else
                                                        Access Disabled
                                                    @endif
                                                </td>

                                                <div class="modal fade" id="modal-lg-reset-{{$user->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.users.reset', $user->id) }}" method="POST" id="reset_password">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Reset Password User </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Password</label><span class="text-gray text-sm"> (Harus kombinasi huruf dan angka minimum 6 karakter)</span>
                                                                                <input type="password" class="form-control" name="password" placeholder="Silahkan masukan password" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Ulangi Password</label><span class="text-gray text-sm"> (Harus kombinasi huruf dan angka minimum 6 karakter)</span>
                                                                                <input type="password" class="form-control" name="confirm_password" placeholder="Silahkan masukan password" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="submit" id="btn_reset" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                    </form>
                                                    <!-- /.modal-dialog -->
                                                </div>

                                                <div class="modal fade" id="modal-lg-edit-{{$user->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.users.update', $user) }}" method="POST" id="update_user">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Edit Data User </strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            @if(auth()->user()->roles[0]->name != $user->roles[0]->name)
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Role/Level</label>
                                                                                <select class="form-control" name="roles[]">
                                                                                    <option value="" selected disabled>-- Pilih Role/Level --</option>
                                                                                    @foreach($roles as $role)
                                                                                        @if(auth()->user()->roles[0]->name == 'Super Admin')
                                                                                            <option value="{{ $role->name }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>{{$role->name}}</option>
                                                                                        @elseif(auth()->user()->roles[0]->name == 'Kepala Dinas' || auth()->user()->roles[0]->name == 'Kepala Bidang')
                                                                                            @if($role->id > auth()->user()->roles[0]->id)
                                                                                                <option value="{{ $role->name }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>{{$role->name}}</option>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            @endif
                                                                            @can('tambah pengguna bidang')
                                                                                @if(auth()->user()->roles[0]->name != $user->roles[0]->name)
                                                                                    <div class="form-group">
                                                                                        <label class="text-darkblue">Bidang</label>
                                                                                        <select class="form-control" name="bidang_id">
                                                                                            <option value="" selected disabled>-- Pilih Bidang --</option>
                                                                                            @foreach($bidang as $bid)
                                                                                                <option value="{{ $bid->id }}" {{ $user->bidang_id == $bid->id ? 'selected' : '' }}>{{$bid->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                @endif
                                                                            @endcan
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Nama</label>
                                                                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Silahkan masukan nama pengguna" required>
                                                                            </div>
																																						<div class="form-group">
																																							<label class="text-darkblue">NIP</label>
																																							<input type="text" class="form-control" name="nip" value="{{ $user->nip }}" placeholder="Silahkan masukan NIP" required>
																																						</div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Username</label><span class="text-gray text-sm"> (Tidak boleh mengandung karakter khusus)</span>
                                                                                <input type="text" class="form-control" name="username" value="{{ $user->username }}" placeholder="Silahkan masukan username" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Email</label>
                                                                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Silahkan masukan email" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-darkblue">Telepon</label>
                                                                                <input type="text" class="form-control" name="phone_number" value="{{ $user->phone_number }}" placeholder="Silahkan masukan nomor telepon" required>
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
                                                <div class="modal fade" id="modal-delete-{{$user->id}}" style="padding-right: 17px; ">
                                                    <form action="{{ route('backend.users.destroy', $user->id) }}" method="POST" id="delete_user">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"><strong> Hapus User </strong></h5>
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
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted"><i>{{ __('Data pengguna kosong') }}</i>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-lg-create" style="padding-right: 17px; ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong> Tambah Data User </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="text-darkblue">Role/Level</label>
                                <select class="form-control" name="roles[]" required>
                                    <option value="" selected disabled>-- Pilih Role/Level --</option>
                                    @foreach($roles as $role)
                                        @if(auth()->user()->roles[0]->name == 'Super Admin')
                                          <option value="{{ $role->name }}">{{$role->name}}</option>
                                        @elseif(auth()->user()->roles[0]->name == 'Kepala Dinas' || auth()->user()->roles[0]->name == 'Kepala Bidang')
                                            @if($role->id > auth()->user()->roles[0]->id)
                                                <option value="{{ $role->name }}">{{$role->name}}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @can('tambah pengguna bidang')
                            <div class="form-group">
                                <label class="text-darkblue">Bidang</label>
                                <select class="form-control" name="bidang_id">
                                    <option value="" selected disabled>-- Pilih Bidang --</option>
                                    @foreach($bidang as $bid)
                                        <option value="{{ $bid->id }}">{{$bid->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endcan
                            <div class="form-group">
                                <label class="text-darkblue">Nama</label>
                                <input type="text" class="form-control" name="name" placeholder="Silahkan masukan nama pengguna" required>
                            </div>
														<div class="form-group">
															<label class="text-darkblue">NIP</label>
															<input type="text" class="form-control" name="nip" placeholder="Silahkan masukan NIP" required>
														</div>
                            <div class="form-group">
                                <label class="text-darkblue">Username</label><span class="text-gray text-sm"> (Tidak boleh mengandung karakter khusus)</span>
                                <input type="text" class="form-control" name="username" placeholder="Silahkan masukan username" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Password</label><span class="text-gray text-sm"> (Harus kombinasi huruf dan angka minimum 6 karakter)</span>
                                <input type="password" class="form-control" name="password" placeholder="Silahkan masukan password" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Ulangi Password</label><span class="text-gray text-sm"> (Harus kombinasi huruf dan angka minimum 6 karakter)</span>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Silahkan masukan password" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Silahkan masukan email" required>
                            </div>
                            <div class="form-group">
                                <label class="text-darkblue">Telepon</label>
                                <input type="text" class="form-control" name="phone_number" placeholder="Silahkan masukan nomor telepon">
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
            $(".search input").before(`<span class="fa fa-search"></span>`);
            $(".search input").attr("placeholder", "Ketik Kata Kunci");
        });
    </script>
@endsection
