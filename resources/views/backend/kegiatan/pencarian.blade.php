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
        <li class="breadcrumb-item"><span class=" text-lightgray">{{ __('Kegiatan') }}</span></li>
        <li class="breadcrumb-item active">{{ __('Pencarian') }}</li>
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
                    <a href="{{route('backend.kegiatan.search')}}" class="btn btn-default btn-sm" ><i class="fas fa-search"></i> Pencarian</a>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-lg-dana"><i class="fa fa-money"></i> Sumber Dana</button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-lg-print"><i class="fas fa-print"></i> Cetak Laporan</button>
                    {{-- <div class="input-group-prepend"> --}}
											@can('tambah kegiatan')
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
													<i class="fas fa-plus"></i> Tambah
												</button>
												<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
														<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-lg-create">Manual</a>
														<a class="dropdown-item" href="#">Upload Excel DPA</a>
														<a class="dropdown-item" href="#">Import SIMDA</a>
												</div>
											@endcan
                    {{-- </div> --}}
                </div>
						</div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Pencarian</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<form action="" method="GET">
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control" name="search" placeholder="Masukan Kata kunci pencarian">
                            </div>
														<div class="col-3">
															<select name="jenis_paket" id="jenis_paket" class="form-control">
																<option value="" selected>-- Pilih Tipe Paket --</option>
																<option value="1">Paket Fisik</option>
																<option value="2">Paket Non Fisik</option>
															</select>
                            </div>
														<div class="col-1">
                                <button type="submit" class="btn btn-primary btn-block">Cari</button>
                            </div>
														<div class="col-1">
															<a href="{{route('backend.kegiatan.search')}}" id="btn-reset" class="btn btn-danger btn-block d-none">Reset</a>
													</div>
                        </div>
											</form>
                    </div>
                </div>
            </div>
            <!-- /.card -->
						<div class="card">
							<div class="card-body">
								<div class="card-body table-responsive p-0" style="height: 500px;">
										<table class="table  text-nowrap">
												<tbody>
														@foreach ($detailKegiatan as $kegiatan)
																<tr>
																	<td style="width: 50%">
																		<span class="text-lightblue text-bold">{{$kegiatan->title}}</span>
																	</td>
																	<td style="width: 30%">
																		<span class="text-darkblue">Rp.{{number_format($kegiatan->pagu)}}</span>
																	</td>
																	<td style="width: 20%">
																		<div class="card-detail-right">
																			<button type="button" class=" btn btn-sm btn-default " ><i class="fas fa-eye"></i> Lihat Detail</button>
																		</div>
																	</td>
															</tr>
														@endforeach
												</tbody>
										</table>
								</div>
							</div>
						</div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-lg-create">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><strong> Tambah Data Kegiatan (Manual) </strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					<form action="{{ route('backend.kegiatan.store') }}" method="POST" id="submit_kegiatan">
							@csrf
							<div class="row">
									<div class="col-sm-12">
										<!-- text input -->
										<div class="form-group">
											<label class="text-darkblue">Judul Kegiatan</label>
											<input type="text" class="form-control" name="title" placeholder="Silahkan masukan judul Kegiatan" required>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Nomor Rekening</label>
											<input type="text" class="form-control" name="no_rek" placeholder="Silahkan masukan nomor rekening" required>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Tahun Kegiatan</label>
											<input type="text" class="form-control" name="tahun" placeholder="Silahkan masukan tahun kegiatan" required>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Program</label>
											<select name="program" id="program" class="form-control" required>
													<option selected>-- Pilih Program --</option>
													@foreach ($program as $value)
															<option value="{{$value->id}}">{{$value->name}}</option>
													@endforeach
											</select>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Nomor Rekening Program</label>
											<input type="text" class="form-control" name="no_rek_program" placeholder="Silahkan masukan nomor rekening program" required>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Bidang</label>
											<select name="bidang_id" id="bidang_id" class="form-control" required>
													<option selected>-- Pilih Bidang --</option>
													@foreach ($bidang as $value)
															<option value="{{$value->id}}">{{$value->name}}</option>
													@endforeach
											</select>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Pilih Sumber Dana</label>
											<select name="sumber_dana" id="sumber_dana" class="form-control" required>
													<option selected>-- Pilih Sumber dana --</option>
													@foreach ($sumber_dana as $item)
															<option value="{{$item->id}}">{{$item->name}}</option>
													@endforeach
											</select>
										</div>
										<div class="form-group">
											<label class="text-darkblue">Tipe Paket</label>
											<select name="jenis_paket" id="jenis_paket" class="form-control" required>
													<option selected>-- Pilih Tipe Paket --</option>
													<option value="1">Paket Fisik</option>
													<option value="2">Paket Non Fisik</option>
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
<div class="modal fade" id="modal-lg-dana">
	<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title"><strong> List Sumber Dana </strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body">
							<div class="row">
							<div class="col-sm-12">
									<div class="custom-control custom-checkbox">
											<input class="custom-control-input" type="checkbox" id="dana" checked="">
											<label for="dana" class="custom-control-label">APBD</label>
									</div>
							</div>
							</div>
					</div>
					<div class="modal-footer justify-content-center">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
					</div>
			</div>
			<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-lg-print">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><strong> Laporan </strong></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
							<!-- text input -->
							<div class="form-group">
									<label class="text-darkblue">Pilih Bulan</label>
									<select name="bulan" id="bulan_laporan" class="form-control" required>
											<option value="" selected>-- Pilih Bulan --</option>
											<option value="januari">Januari</option>
											<option value="februari">Februari</option>
											<option value="maret">Maret</option>
											<option value="april">April</option>
											<option value="mei">Mei</option>
											<option value="juni">Juni</option>
											<option value="juli">Juli</option>
											<option value="agustus">Agustus</option>
											<option value="september">September</option>
											<option value="oktober">Oktober</option>
											<option value="november">November</option>
											<option value="desember">Desember</option>
									</select>
							</div>
							<div class="form-group">
									<label class="text-darkblue">Pilih Tahun</label>
									<select name="tahun" id="tahun_laporan" class="form-control" required>
										<option value="" selected>-- Pilih Tahun --</option>
										@for ($i = 0; $i < 5; $i++)
											<option value="{{date('Y')-$i}}">{{((int)date('Y'))-$i}}</option>
										@endfor
									</select>
							</div>
					</div>
			</div>
			</div>
			<div class="modal-footer justify-content-end">
				<button type="button" onclick="cetakLaporan()" class="btn btn-primary" data-dismiss="modal">Simpan</button>
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
    var search = getUrlParameter('search');
		var jenis_paket = getUrlParameter('jenis_paket');
		if (search || jenis_paket) {
			$('#btn-reset').removeClass('d-none');
		}else{
			$('#btn-reset').addClass('d-none');
		}
  });
	var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
	};
	function cetakLaporan() {
		var bulan = $('#bulan_laporan').val();
		var tahun = $('#tahun_laporan').val();
		window.location = `/backend/kegiatan/laporan?bulan=${bulan}&tahun=${tahun}`
	}
</script>
@endsection
