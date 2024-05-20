@extends('layouts.main')

@section('title', 'DPA Result')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
		<!-- SweetAlert2 -->
		<link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item "><a href="{{ route('backend.dpa.index') }}" class="text-lightgray fs-14">{{ __('DPA') }}</a></li>
        <li class="breadcrumb-item "><a href="{{ route('backend.dpa.show', $dpa->id) }}" class="text-lightgray fs-14">{{ __('Detail DPA') }}</a></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Result DPA') }}</span></li>
    </ol>
</div>
@endsection

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Berhasil Menyimpan Data
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card card-default">
			<div class="card-header">
				<h4 class="text-darkblue"><strong> <a href="{{route('backend.dpa.index')}}" class="btn btn-default rounded"><i class="fas fa-arrow-left"></i></a> RESULT DATA DPA </strong></h4>
			</div>
			<div class="card-body">
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
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="row">
								<h4 class="text-darkblue"><strong> Sub Kegiatan </strong></h4>
						</div>
						<table id="example1" class="table" style="width: 100%;">
							<thead>
							<tr>
									<th style="padding:1rem 2.25rem;">SUB KEGIATAN / SUMBER DANA / LOKASI</th>
									<th>Total Pagu</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($sub_kegiatan as $item)
								<tr>
									<td>
										<p class="text-xs text-bold">- <span class="italic">{{$item->no_kontrak}} | {{$item->detail_kegiatan}}</span></p>
										<p class="text-xs text-bold ml-2">- <span class="italic">{{$item->sumber_dana}}</span></p>
										<p class="text-xs text-bold ml-4">- <span class="italic">{{$item->lokasi}}</span></p>
									</td>
									<td>Rp{{number_format($item->total_pagu)}}</td>
								</tr>
								@endforeach
								</tbody>
							</table>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
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
								<div class="row">
									<h4 class="text-darkblue"><strong> History Rencana Pengambilan </strong></h4>
								</div>
								<table class="table" id="pengambilan" style="width: 100%;">
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
				</div>
				<div class="row">
					<div class="col-12">
						<div class="row">
								<h4 class="text-darkblue"><strong> Pengguna Anggaran </strong></h4>
						</div>
						<table id="pengguna_anggaran" class="table" style="width: 100%;">
							<thead>
							<tr>
									<th style="padding:1rem 2.25rem;">Nama</th>
									<th>NIP</th>
									<th>Jabatan</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($pengguna as $item)
								<tr>
										<td>{{$item->name}}</td>
										<td>{{$item->nip}}</td>
										<td>{{$item->jabatan}}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="row">
								<h4 class="text-darkblue"><strong> Tanda Tangan </strong></h4>
						</div>
						<table id="tanda_tangan" class="table" style="width: 100%;">
							<thead>
							<tr>
									<th style="padding:1rem 2.25rem;">Nama</th>
									<th>NIP</th>
									<th>Jabatan</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($ttd as $item)
								<tr>
										<td>{{$item->name}}</td>
										<td>{{$item->nip}}</td>
										<td>{{$item->jabatan}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<a href="{{route('backend.dpa.index')}}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
			</div>
		</div>
		<!-- /.card -->
	</div>
</div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  $(function () {
		var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
		Toast.fire({
			icon: 'success',
			title: 'Berhasil Menyimpan Data'
		})
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "collapsed": true,
    });
    $("#example1_filter").addClass('btn-action-right');
    $("#example1_filter label").addClass('search');
    
    $("#btn_submit").on("click", function (){
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
    $("#pengambilan_filter").addClass('btn-action-right');
    $("#pengambilan_filter label").addClass('search');
    
    $("#btn_submit_pengambilan").on("click", function (){
        $("#submit_sub_pengambilan").submit();
    });
		$("#pengguna_anggaran").DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "collapsed": true,
    });
    $("#pengguna_anggaran_filter").addClass('btn-action-right');
    $("#pengguna_anggaran_filter label").addClass('search');
    
    $("#btn_submit_pengguna_anggaran").on("click", function (){
        $("#submit_sub_pengguna_anggaran").submit();
    });
		$("#tanda_tangan").DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "collapsed": true,
    });
    $("#tanda_tangan_filter").addClass('btn-action-right');
    $("#tanda_tangan_filter label").addClass('search');
    $(".search input").before( `
        <span class="fa fa-search"></span>
    `);
    $(".search input").attr("placeholder", "Ketik Kata Kunci");
    $("#btn_submit_tanda_tangan").on("click", function (){
        $("#submit_sub_tanda_tangan").submit();
    });
  });
</script>
<script>
	function getPengambilanByDpa(dpa_id, bulan) {
		let token   = $("meta[name='csrf-token']").attr("content");
		$.ajax({
				url: `{{route('backend.pengambilan.get.dpa')}}`,
				type: "GET",
				cache: false,
				data: {
						"dpa_id": dpa_id,
						"bulan": bulan,
						"_token": token
				},
				success:function(response){
						if (response.success) {
								if(response.data){
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
				error:function(response){
						console.log('error');
				}
		});
	}
</script>
@endsection
