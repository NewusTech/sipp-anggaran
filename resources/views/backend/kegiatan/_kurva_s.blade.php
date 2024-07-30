<div class="tab-pane fade show {{ session('tab') == 'kurva_s' ? 'active' : '' }}" id="custom-content-below-kurva-s" role="tabpanel" aria-labelledby="custom-content-below-kurva-s-tab">
    <div class="p-3">
        <ul class="nav nav-tabs pb-1" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link py-1 {{session('tab') == ''? 'active' : ''}}" id="custom-content-below-fisik-tab" data-toggle="pill" href="#custom-content-above-fisik" role="tab" aria-controls="custom-content-below-fisik" aria-selected="true">Fisik</a>
            </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
            @include('backend.kegiatan.tab_kurva_s.tab_fisik')
        </div>
    </div>
</div>
