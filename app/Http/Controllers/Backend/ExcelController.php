<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\ImportKegiatan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function importKegiatan(Request $request){
        // dd($request->file('file'), $request->import_kegiatan);
        Excel::import(new ImportKegiatan, $request->file('import_kegiatan'));
        return redirect()->back()->with('success', 'Data Kegiatan berhasil diimport');
    }
}
