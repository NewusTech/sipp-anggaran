<div class="tab-pane fade show {{session('tab') == ''? 'active' : ''}}" id="custom-content-below-data-kontrak" role="tabpanel" aria-labelledby="custom-content-below-detail-tab">
    <div class="row">
        <div class="col-12">
            <table class="table table-responsive">
                <tr>
                    <td class="text-bold text-darkblue">Detail Kegiatan</td>
                    <td>{{ $detail->title }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Kegiatan</td>
                    <td>{{ $detail->kegiatan->title }}</td>
                </tr>
                <tr>
                    <td class="text-bold text-darkblue">Program</td>
                    <td>{{ $kegiatan->program }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
