<div class="modal fade" id="modal-lg-edit-pengambilan">
	<div class="modal-dialog modal-lg">
		<form action="{{route('backend.pengambilan.store')}}" method="POST">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Rencana Pengambilan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
							<div class="col-sm-12">
									<input type="text" hidden="true" name="detail_kegiatan_id" value="{{ request()->detail_kegiatan_id }}">
									<div class="form-group">
											<label class="text-darkblue">Bulan</label>
											<select name="bulan" id="bulan" class="form-control" onchange="getPengambilan('{{ request()->detail_kegiatan_id }}', this.value)">
													<option value="">-- Silahkan Pilih Bulan --</option>
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
							</div>
					</div>
					<div class="row">
						<div class="col-6">
								<div class="form-group">
									<label class="text-darkblue">Belanja Operasi</label>
									<input type="number" class="form-control" name="belanja_operasi" id="belanja_operasi"  placeholder="Silahkan masukan Belanja Operasi" >
								</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="text-darkblue">Belanja Modal</label>
								<input type="number" class="form-control" name="belanja_modal" id="belanja_modal"  placeholder="Silahkan masukan Belanja modal" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
								<div class="form-group">
									<label class="text-darkblue">Belanja Tak Terduga</label>
									<input type="number" class="form-control" name="belanja_tak_terduga"  id="belanja_tak_terduga" placeholder="Silahkan masukan Belanja Tak Terduga" >
								</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="text-darkblue">Belanja Transfer</label>
								<input type="number" class="form-control" name="belanja_transfer" id="belanja_transfer"  placeholder="Silahkan masukan Belanja transfer" >
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label class="text-darkblue">Keterangan</label>
								<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Silahkan masukan keterangan">
						</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>