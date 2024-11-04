<?php

namespace App\Http\Controllers\apI;

use App\Exports\LaporanPengambilanExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownloadLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }
    public function downloadLaporan(Request $request)
    {
        $date = date('Y-m-d');
        return Excel::download(new LaporanPengambilanExport($request), $date . 'laporan_kegiatan.xlsx');
    }
}
