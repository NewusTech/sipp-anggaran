<?php

namespace App\Http\Controllers\Backend;

use App\Exports\AnggaranKeuanganExport;
use App\Exports\AnggaranProgressExport;
use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GrafikAnggaranController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if ($request->type == 'realisasi') {

        } elseif ($request->type == 'schedule') {

        } else {

        }


        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadProgress(Request $request): BinaryFileResponse
    {

        return Excel::download(new AnggaranProgressExport, 'data_rogress'.$request->type.'.xlsx');
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function downloadKeuangan(Request $request): BinaryFileResponse
    {
        return Excel::download(new AnggaranKeuanganExport, 'data_keuangan.xlsx');
    }
}
