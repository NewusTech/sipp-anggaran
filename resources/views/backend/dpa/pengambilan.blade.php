@extends('layouts.main')

@section('title', 'Rencana Pengambilan')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
			<li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
			<li class="breadcrumb-item  "><a href="{{ route('backend.rencana.program') }}" class="text-lightgray fs-14">{{ __('List Program') }}</a></li>
			<li class="breadcrumb-item  "><a href="{{ route('backend.rencana.kegiatan',['program_id' => $program->id]) }}" class="text-lightgray fs-14">{{ __('List Kegiatan') }}</a></li>
			<li class="breadcrumb-item  "><a href="{{route('backend.rencana.detail',['kegiatan_id' => $kegiatan->id,'program_id'=>$program->id])}}" class="text-lightgray fs-14">{{ __('List Sub Kegiatan') }}</a></li>
			<li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Rencana Pengambilan') }}</span></li>
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
                <div class="row">
                    <h4 class="text-darkblue"><strong> Rencana Pengambilan </strong></h4>
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Rencana Pengambilan</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<div class="row">
												<div class="col-12">
														<div class="card">
																<div class="card-body">
																		<div class="row">
																				<div class="col-12">
																						<div class="flex justify-content-between ">
																								<div class="flex flex-col p-2">
																										<p class="text-xs text-bold">- Program: <span class="italic">{{$program->kode}} | {{$program->name}}</span></p>
																										<p class="text-xs text-bold ml-2">- Kegiatan: <span class="italic">{{$kegiatan->no_rek}} | {{$kegiatan->title}}</span></p>
																										<p class="text-xs text-bold ml-4">- Sub Kegiatan: <span class="italic">{{$detail->no_kontrak}} | {{$detail->title}}</span></p>
																								</div>
																								<div class="right">
																										<p>Total Pagu: Rp {{number_format($detail->pagu)}}</p>
																										<p>Terealisasi: Rp {{number_format($detail->realisasi)}}</p>
																										<p>Presentasi: {{$detail->realisasi > 0 ? round(($detail->realisasi/$detail->pagu)*100) : 0}} %</p>
																								</div>
																						</div>
																						<hr>
																				</div>
																		</div>
																		<div class="row">
																				<div class="col-12">
																						<div class="text-right" style="margin-bottom: 2.4rem;">
																								<button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modal-lg-edit-pengambilan"><i class="fas fa-edit"></i> Input Rencana Pengambilan</button>
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
																				</div>
																		</div>
																		<div class="row">
																				<div class="col-12">
																						<label>History Rencana Pengambilan</label>
																						<table class="table" id="table_pengambilan">
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
												</div>
										</div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@include('backend.kegiatan._modal_pengambilan')
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
    $(".search input").before( `
        <span class="fa fa-search"></span>
    `);
    $(".search input").attr("placeholder", "Ketik Kata Kunci");
    $("#btn_submit").on("click", function (){
        $("#submit_dpa").submit();
    });
		$("#table_pengambilan").DataTable({
				"responsive": true,
				"autoWidth": false,
				"paging": true,
				"lengthChange": true,
				"searching": false,
				"ordering": true,
				"collapsed": true,
		});
  });
</script>
<script>
	function getPengambilan(detail_kegiatan_id, bulan) {
		let token   = $("meta[name='csrf-token']").attr("content");
		$.ajax({
				url: `{{route('backend.pengambilan.get')}}`,
				type: "GET",
				cache: false,
				data: {
						"detail_kegiatan_id": detail_kegiatan_id,
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
