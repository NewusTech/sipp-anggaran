<?php

namespace App\Http\Controllers\apI;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    public function RealisasiKeuangan(Request $request)
    {
        $year = $request->input('year', date('Y'));

        try {

            $realsisasi_keuangan_from_detail_kegitan = DetailKegiatan::select('id', 'title')
                ->with(['progres' => function ($query) {
                    $query->orderByDesc('nilai')
                        ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai')
                        ->limit(1);
                }])
                ->whereHas('progres', function ($query) {
                    $query->where('jenis_progres', 'keuangan');
                    // ->orderByDesc('nilai')
                    // ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai')
                    // ->limit(1);
                })
                ->whereYear('created_at', $year)
                ->get();
            $data = $realsisasi_keuangan_from_detail_kegitan;
            return response()->json([
                'success' => true,
                'message' => 'Get Dashboard Data Success',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function RealisasiFisik(Request $request)
    {
        $year = $request->input('year', date('Y'));

        try {

            $realsisasi_fisik_from_detail_kegitan = DetailKegiatan::select('id', 'title')
                ->with(['progres' => function ($query) {
                    $query->orderByDesc('nilai')
                        ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai')
                        ->limit(1);
                }])
                ->whereHas('progres', function ($query) {
                    $query->where('jenis_progres', 'fisik')
                        ->orderByDesc('nilai')
                        ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai')
                        ->limit(1);
                })
                ->whereYear('created_at', $year)
                ->get();
            $data = $realsisasi_fisik_from_detail_kegitan;
            return response()->json([
                'success' => true,
                'message' => 'Get Dashboard Data Success',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
