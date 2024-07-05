<div class="tab-pane fade show {{session('tab') == 'titik_lokasi' ? 'active' : ''}}" id="custom-content-above-titik-lokasi" role="tabpanel" aria-labelledby="custom-content-below-titik-lokasi-tab">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-12">
            <form action="{{ route('backend.detail_kegiatan.update.map_point', $detail->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="text-darkblue">Maps</label>
                            <span>(Klik Untuk Mendapatkan Koordinat !)</span>
                            <div class="card">
                                <div class="card-body">
                                    <div id="mapDetail"></div>
                                    <input type="hidden" class="form-control" name="latitude" id="inputLatitude" placeholder="Silahkan masukan latitude">
                                    <input type="hidden" class="form-control" name="longitude" id="inputLongitude" placeholder="Silahkan masukan longitude">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary" id="btn-update-anggaran">Simpan</button>
                </div>
            </form>

            <!-- <form action="{{ route('backend.detail_kegiatan.update.map_point', $detail) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <p class="text-bold text-darkblue" style="font-size: 16pt">Titik Lokasi</p>
                            <input type="hidden" class="form-control" name="latitude" id="latitude" placeholder="Silahkan masukan latitude">
                            <input type="hidden" class="form-control" name="longitude" id="longitude" placeholder="Silahkan masukan longitude">
                            <input type="hidden" name="test" value="Halo ini test input">
                            <button type="submit" id="btnSaveMap" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="mapDetail" class="card p-2" style="height: 400px"></div>
                </div>
            </form> -->
        </div>
    </div>
</div>
