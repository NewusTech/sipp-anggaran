@extends('layouts.main')

@section('title', 'Pengaturan Bidang')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('breadcump')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item "><a href="{{ route('backend.dashboard.index') }}" class="text-lightgray fs-14">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><span class=" text-lightgray fs-10">{{ __('Kegiatan') }}</span></li>
        <li class="breadcrumb-item active "><span class="text-darkblue">{{ __('Data Arsip') }}</span></li>
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
@if (session()->has('error'))
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-error alert-dismissible">
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
                </div>
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-bidang-tab" data-toggle="pill" href="#custom-content-below-bidang" role="tab" aria-controls="custom-content-below-bidang" aria-selected="true">Data Arsip</a>
                    </li>
                </ul>

                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-below-bidang" role="tabpanel" aria-labelledby="custom-content-below-bidang-tab">
                        <div class="row">
                            <div class="col-12">
                                <div id="accordion">
                                    @foreach ($tahun as $item)
                                    <div class="card">
                                        <div id="heading-{{$item->tahun}}" onclick="getKegiatan({{$item->tahun}})" class="card-header btn btn-link" data-toggle="collapse" data-target="#collapse-{{$item->tahun}}" aria-expanded="true" aria-controls="collapseOne" style="background-color: #f5faff; border-radius: 0.5rem;">
                                            <div class="card-table">
                                                <p class="taf text-darkblue">
                                                    <strong>Kegiatan Tahun {{$item->tahun}}</strong>
                                                </p>
                                                <div class="card-table-cell tar">
                                                    <button type="button" class=" btn btn-sm btn-secondary rounded" ><strong>Total Kegiatan : {{$item->kegiatan->count()}}</strong></button>
                                                </div>
                                            </div>
                                        </div>
                                  
                                        <div id="collapse-{{$item->tahun}}" class="collapse" aria-labelledby="heading-{{$item->tahun}}" data-parent="#accordion">
                                            <div class="card-body table-responsive p-0" style="height: 500px;">
																							<div id="kegiatan">

																							</div>
                                                <table class="table  text-nowrap">
                                                    <tbody>
                                                        @foreach ($item->kegiatan as $kegiatan)
																														<tr>
																															<td style="width: 40%">
																																	<dl class="word-break">
																																			<dd>
																																					<span class="text-darkblue">{{$kegiatan->title}}</span>
																																			</dd>
																																			<dd style="margin-bottom: 20px;margin-top: 10px;">
																																					<span class="text-darkblue"><strong>No Rekening : </strong> {{$kegiatan->no_rek}}</span>
																																			</dd>
																																	</dl>
																															</td>
																															<td style="width: 20%">
																																	<dl>
																																			<dt>
																																					<label class="text-darkblue">Total Pagu</label>
																																			</dt>
																																			<dd>
																																					<span class="text-darkblue">Rp {{number_format($kegiatan->alokasi)}}</span>
																																			</dd>
																																	</dl>
																															</td>
																															<td style="width: 20%">
																																	<dl>
																																			<dt>
																																					<label class="text-darkblue">Realisasi</label>
																																			</dt>
																																			<dd>
																																					<span class="text-darkblue">Rp 2.280.365,00</span>
																																			</dd>
																																	</dl>
																															</td>
																															<td style="width: 20%">
																																	<dl>
																																			<dt>
																																					<label class="text-darkblue">Sisa Anggaran</label>
																																			</dt>
																																			<dd>
																																					<span class="text-darkblue">Rp 210.459,00</span>
																																			</dd>
																																	</dl>
																															</td>
																													</tr>
																													<tr>
																														<td colspan="4">
																																<div id="accordion-detail">
																																	<div class="justify-content-start text-darkblue" id="heading-detail-{{$kegiatan->id}}"  data-toggle="collapse" data-target="#detail-{{$kegiatan->id}}">
																																		<a href="#" class="text-lightblue" ><h6>Lihat Daftar Paket & Anggaran</h6></a>
																																	</div>
																																	<div id="detail-{{$kegiatan->id}}" class="collapse" aria-labelledby="heading-detail-{{$kegiatan->id}}" data-parent="#accordion-detail">
																																		@if ($kegiatan->detail_kegiatan->count() > 0)
																																			@foreach ($kegiatan->detail_kegiatan as $detail)
																																			<div class="row">
																																				<div  class="col-12 " data-toggle="collapse">
																																					<table class="table table-borderless">
																																						<tr>
																																							<td class="text-lightblue" style="display: flex;">
																																									<strong>{{$detail->title}}</strong>
																																							</td>
																																							<td>
																																								<div class="text-darkblue" style="display: flex;text-align: left; justify-content: flex-end;">
																																									<dl>
																																										<dt>
																																												<label class="text-darkblue">Pagu</label>
																																										</dt>
																																										<dd>
																																												<span class="text-darkblue">Rp.{{ number_format($detail->pagu) }}</span>
																																										</dd>
																																									</dl>
																																								</div>
																																							</td>
																																							<td>
																																								<div style="display: flex;justify-content: flex-end;">
																																									@can('lihat detail kegiatan')
																																										<a href="{{ route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail->id]) }}" class=" btn btn-sm btn-default " ><i class="fas fa-eye"></i> Lihat Detail</a>
																																									@endcan
																																								</div>
																																							</td>
																																						</tr>
																																					</table>
																																				</div>
																																			</div>
																																			@endforeach	
																																		@else
																																			<div class="card">
																																				<div  class="card-header btn btn-link" data-toggle="collapse">
																																						<div class="card-beetween">
																																								<div class="text-center text-darkblue">
																																										<span>No data available in table</span>
																																								</div>
																																						</div>
																																				</div>
																																			</div>
																																		@endif
																																	</div>
																																</div>
																														</td>
																													</tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
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
@endsection

@section('js')
<script>
  $(function () {
    $("#btn_submit").on("click", function (){
        $("#submit_kegiatan").submit();
    });
		
  });

	function getKegiatan(id) {
		let token   = $("meta[name='csrf-token']").attr("content");
		$.ajax({

				url: `{{route('backend.kegiatan.getKegiatan')}}`,
				type: "GET",
				cache: false,
				data: {
						"id": id,
						"_token": token
				},
				success:function(response){
					console.log("wkwk", id);
						if (response.success) {
								if(response.data.length > 0){
										$('#list-product').removeClass('display-unactive');
										$('#list-product').addClass('display-active');
										console.log(response.data);
										
										$('#spinner').addClass('display-unactive');
								}else{
										$('#spinner').addClass('display-unactive');
										$('#blank-product').removeClass('display-unactive');
										$('#blank-product').addClass('display-active');
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
