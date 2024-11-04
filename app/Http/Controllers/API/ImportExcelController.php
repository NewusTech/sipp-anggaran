<?php

namespace App\Http\Controllers\apI;

use App\Http\Controllers\Controller;
use App\Imports\ImportKegiatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function importKegiatan(Request $request)
    {
        try {
            Excel::import(new ImportKegiatan, $request->file('import_kegiatan'));
            return response()->json([
                'status' => 'success',
                'message' => 'Data Kegiatan berhasil diimport'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
