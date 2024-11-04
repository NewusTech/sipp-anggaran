<?php

namespace App\Http\Controllers\apI;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use Illuminate\Http\Request;
use Stringable;

class RealisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }
    public function RealisasiKeuangan(Request $request)
    {
        $request_status = strtolower($request->status);
        if (!in_array($request_status, ['sedang dikerjakan', 'selesai', 'belum dikerjakan'])) {
            $request_status = null;
        }
        $request_tahun = $request->tahun;
        $request_bulan = $request->bulan;
        $request_search = $request->search;

        try {

            $realsisasi_keuangan_from_detail_kegitan = DetailKegiatan::select('id', 'title')
                ->with([
                    'progres' => function ($query) {
                        $query->where('jenis_progres', 'keuangan')
                            ->orderByDesc('nilai')
                            ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai');
                    }
                ])
                ->when($request_tahun, fn($query) => $query->whereYear('created_at', $request_tahun))
                ->when($request_bulan, fn($query) => $query->whereMonth('created_at', $request_bulan))
                ->when($request_search, fn($query) => $query->where('title', 'like', '%' . $request_search . '%'))
                ->when($request_status, function ($query) use ($request_status) {
                    // Filter based on progress status
                    match ($request_status) {
                        'sedang dikerjakan' => $query->whereHas('progres', function ($q) {
                            $q->whereBetween('nilai', [1, 99]);
                        }),
                        'selesai' => $query->whereHas('progres', function ($q) {
                            $q->where('nilai', 100);
                        }),
                        'belum dikerjakan' => $query->whereDoesntHave('progres'),
                        default => null
                    };
                })
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

        $request_status = strtolower($request->status);
        if (!in_array($request_status, ['sedang dikerjakan', 'selesai', 'belum dikerjakan'])) {
            $request_status = null;
        }
        $request_tahun = $request->tahun;
        $request_bulan = $request->bulan;
        $request_search = $request->search;


        try {

            $realsisasi_fisik_from_detail_kegitan = DetailKegiatan::select('id', 'title')
                ->with([
                    'progres' => function ($query) {
                        $query->where('jenis_progres', 'fisik')
                            ->orderByDesc('nilai')
                            ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai');
                    }
                ])
                ->when($request_tahun, fn($query) => $query->whereYear('created_at', $request_tahun))
                ->when($request_bulan, fn($query) => $query->whereMonth('created_at', $request_bulan))
                ->when($request_search, fn($query) => $query->where('title', 'like', '%' . $request_search . '%'))
                ->when($request_status, function ($query) use ($request_status) {
                    // Filter based on progress status
                    match ($request_status) {
                        'sedang dikerjakan' => $query->whereHas('progres', function ($q) {
                            $q->whereBetween('nilai', [1, 99]);
                        }),
                        'selesai' => $query->whereHas('progres', function ($q) {
                            $q->where('nilai', 100);
                        }),
                        'belum dikerjakan' => $query->whereDoesntHave('progres'),
                        default => null
                    };
                })
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
