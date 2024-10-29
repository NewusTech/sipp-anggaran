<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\ProgresKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }


    public function getTotalPaguAndRelasi(Request $request)
    {
        $year = $request->query('year', date('Y'));

        try {
            $bidang_id = [];
            $role = auth('api')->user()->getRoleNames();


            if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang")) {
                array_push($bidang_id, auth('api')->user()->bidang_id);
            }

            $kegiatan = Kegiatan::whereIn('bidang_id', $bidang_id)->pluck('id');

            $total_pagu = $bidang_id == null ? DetailKegiatan::whereYear('created_at', $year)->sum('pagu') : DetailKegiatan::whereIn('kegiatan_id', $kegiatan)->whereYear('created_at', $year)->sum('pagu');

            $detail_kegiatan = DetailKegiatan::select(
                'latitude',
                'longitude'
            )->where('latitude', '!=', null)->where('longitude', '!=', null)->whereYear('created_at', $year)->get();

            $total_realisasi = ProgresKegiatan::whereIn('detail_kegiatan_id', $detail_kegiatan->pluck('id'))
                ->where('jenis_progres', 'keuangan')->whereYear('created_at', $year)->sum('nilai');
            if ($bidang_id == null) {
                $total_realisasi = ProgresKegiatan::where('jenis_progres', 'keuangan')->whereYear('created_at', $year)->sum('nilai');
            }

            $total_sisa = $total_pagu - $total_realisasi;

            $data = [
                'total_pagu' => $total_pagu,
                'total_realisasi' => $total_realisasi,
                'total_sisa' => $total_sisa,
            ];

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

    public function getChartRealisasi(Request $request)
    {
        $year = $request->query('year', date('Y'));
        try {
            $monthlyData = ProgresKegiatan::whereYear('tanggal', $year)
                ->select('nilai', 'jenis_progres', DB::raw('MONTH(tanggal) as bulan'))
                ->get()
                ->groupBy('bulan');

            $result = $monthlyData->map(function ($items, $bulan) {
                return [
                    'bulan' => $bulan,
                    'total_keuangan' => $items->where('jenis_progres', 'keuangan')->sum('nilai'),
                    'total_fisik' => $items->where('jenis_progres', 'fisik')->sum('nilai'),
                ];
            })->sortBy('bulan')->values();

            $data = [
                'chart_data' => $result,
            ];

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

    public function getRealisasiDataAndCont(Request $request)
    {
        $year = $request->query('year', date('Y'));

        try {

            $bidang_id = [];
            $role = auth('api')->user()->getRoleNames();


            if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang")) {
                array_push($bidang_id, auth('api')->user()->bidang_id);
            }

            $kegiatan = Kegiatan::whereIn('bidang_id', $bidang_id)->get(['id']);

            $kegiatan = $kegiatan->map(function ($item) {
                return $item->id;
            });

            $realisasi_fisik_from_detail_kegiatan = DetailKegiatan::select('id', 'title')
                ->with('progres')
                ->whereHas('progres', function ($query) {
                    $query->where('jenis_progres', 'fisik')
                        ->orderByDesc('nilai')
                        ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai')
                        ->limit(1);
                })
                ->whereYear('created_at', $year)
                ->get()
                ->sortByDesc(function ($detailKegiatan) {
                    return $detailKegiatan->progres->first()->nilai ?? 0;
                });

            $realsisasi_keuangan_from_detail_kegitan = DetailKegiatan::select('id', 'title')
                ->with('progres')
                ->whereHas('progres', function ($query) {
                    $query->where('jenis_progres', 'keuangan')
                        ->orderByDesc('nilai')
                        ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai')
                        ->limit(1);
                })
                ->whereYear('created_at', $year)
                ->get()
                ->sortByDesc(function ($detailKegiatan) {
                    return $detailKegiatan->progres->first()->nilai ?? 0;
                });

            $count_paket = DetailKegiatan::whereYear('created_at', $year)
                ->whereHas('kegiatan', function ($query) use ($bidang_id) {
                    $query->where('is_arship', 0);
                    if ($bidang_id) {
                        $query->whereIn('bidang_id', $bidang_id);
                    }
                })
                ->whereYear('created_at', $year)
                ->get()->count();

            $count_paket_belum_mulai = DetailKegiatan::whereDoesntHave('progres')
                ->whereHas('kegiatan', function ($query) use ($bidang_id) {
                    if ($bidang_id) {
                        $query->whereIn('bidang_id', $bidang_id);
                    }
                })
                ->whereYear('created_at', $year)
                ->get()
                ->count();

            $count_paket_dikerjakan = DetailKegiatan::whereHas('progres', function ($query) {
                $query->where('nilai', '>', 0);
            })->whereHas('kegiatan', function ($query) use ($bidang_id) {
                if ($bidang_id) {
                    $query->whereIn('bidang_id', $bidang_id);
                }
            })
                ->whereYear('created_at', $year)
                ->get()
                ->count();

            $total_paket_selesai = DetailKegiatan::whereHas('progres', function ($query) {
                $query->where('nilai', '>=', 100);
            })->whereHas('kegiatan', function ($query) use ($bidang_id) {
                if ($bidang_id) {
                    $query->whereIn('bidang_id', $bidang_id);
                }
            })
                ->whereYear('created_at', $year)
                ->get()
                ->count();

            $data = [
                'realisasi_keuangan' => $realsisasi_keuangan_from_detail_kegitan,
                'realisasi_fisik' => $realisasi_fisik_from_detail_kegiatan,
                'total_paket' => $count_paket,
                'total_paket_belum_mulai' => $count_paket_belum_mulai,
                'total_paket_dikerjakan' => $count_paket_dikerjakan,
                'total_paket_selesai' => $total_paket_selesai
            ];

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
