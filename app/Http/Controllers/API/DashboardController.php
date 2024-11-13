<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\PenanggungJawab;
use App\Models\ProgresKegiatan;
use App\Models\RencanaKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                ->orderBy('bulan')
                ->get()
                ->groupBy('bulan');

            $chartDatafisik = $monthlyData->map(function ($items, $bulan) {
                return $items->where('jenis_progres', 'fisik')->sum('nilai');
            });

            $chartDataKeuangan = $monthlyData->map(function ($items, $bulan) {
                return $items->where('jenis_progres', 'keuangan')->sum('nilai');
            });

            $chartDatafisik = $chartDatafisik->toArray();
            $chartDataKeuangan = $chartDataKeuangan->toArray();
            $bulan = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

            foreach ($bulan as $value) {
                if (!array_key_exists($value, $chartDatafisik)) {
                    $chartDatafisik[$value] = 0;
                }
                if (!array_key_exists($value, $chartDataKeuangan)) {
                    $chartDataKeuangan[$value] = 0;
                }
            }
            ksort($chartDatafisik);
            ksort($chartDataKeuangan);
            $data = [
                'chart_data' => [
                    'labels' => array_keys($chartDatafisik),
                    'data_fisik' => array_values($chartDatafisik),
                    'data_keuangan' => array_values($chartDataKeuangan)
                ],
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
            $realisasi_fisik_from_detail_kegiatan = DetailKegiatan::select('id', 'title',  'alamat', 'jenis_pengadaan', 'penyedia_jasa', 'kegiatan_id')
                ->with([
                    'kegiatan' => function ($query) {
                        $query->select('id', 'title', 'bidang_id')
                            ->with(['bidang' => function ($query) {
                                $query->select('id', 'name');
                            }]);
                    },
                    'progres' => function ($query) {
                        $query->where('jenis_progres', 'fisik')
                            ->orderByDesc('nilai')
                            ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai');
                    },
                ])
                ->whereYear('created_at', $year)
                ->get();


            $realsisasi_keuangan_from_detail_kegitan = DetailKegiatan::select('id', 'title',  'alamat', 'jenis_pengadaan', 'penyedia_jasa', 'kegiatan_id')
                ->with([
                    'kegiatan' => function ($query) {
                        $query->select('id', 'title', 'bidang_id')
                            ->with(['bidang' => function ($query) {
                                $query->select('id', 'name');
                            }]);
                    },
                    'progres' => function ($query) {
                        $query->where('jenis_progres', 'kuangan')
                            ->orderByDesc('nilai')
                            ->select('id', 'detail_kegiatan_id', 'minggu', 'bulan', 'jenis_progres', 'nilai');
                    },
                ])
                ->whereYear('created_at', $year)
                ->get();

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
                'realisasi_fisik' => $realisasi_fisik_from_detail_kegiatan,
                'realisasi_keuangan' => $realsisasi_keuangan_from_detail_kegitan,
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

    public function getLokasiMaps()
    {

        $user = auth('api')->user();
        $bidang_id = $user->bidang_id;
        try {
            $detail_kegiatan = DetailKegiatan::select(
                'latitude',
                'longitude'
            )->where('latitude', '!=', null)->where('longitude', '!=', null)
                ->whereHas('kegiatan', function ($query) use ($bidang_id) {
                    $query->where('bidang_id', $bidang_id);
                })
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Get Dashboard Data Success',
                'data' => $detail_kegiatan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getTabelData(Request $request)
    {
        $year = $request->query('year', date('Y'));
        $count = $request->query('count', 10);

        try {

            $bidang_id = [];
            $role = auth('api')->user()->getRoleNames();


            if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang")) {
                array_push($bidang_id, auth('api')->user()->bidang_id);
            }

            // Get the `DetailKegiatan` data with relationships and filters
            $fisik = DetailKegiatan::select(
                'id',
                'title',
                'progress',
                'akhir_kontrak',
                'latitude',
                'longitude',
                'kegiatan_id',
                'penanggung_jawab_id',
                'penyedia_jasa_id'
            )
                ->with([
                    'kegiatan' => function ($query) {
                        $query->select('id', 'title', 'bidang_id', 'alokasi', 'program')
                            ->where('is_arship', 0);
                    },
                    'kegiatan.bidang:id,name',
                    'penanggungJawab',
                    'progres',
                    'rencana_kegiatans',
                    'penyedia'
                ])
                ->whereHas('kegiatan', function ($query) use ($bidang_id) {
                    if (!empty($bidang_id)) {
                        $query->whereIn('bidang_id', $bidang_id);
                    }
                })
                ->whereYear('created_at', $year)
                ->paginate($count);

            if ($role[0] == 'Pengawas') {
                $pengawas = PenanggungJawab::where('pptk_email', Auth::user()->email)->first('id');
                if ($pengawas) {
                    $fisik = $fisik->where('penanggung_jawab_id', $pengawas->id);
                }
            }

            $fisik->map(function ($item) {
                $progres = $item->progres()
                    ->where('jenis_progres', 'fisik')
                    ->orderBy('nilai', 'desc')
                    ->first();

                $item->status_deviasi = 'Data rencana atau realisasi tidak ditemukan';

                if (!$progres) {
                    return $item;
                }

                $rencana = $item->rencana_kegiatans()
                    ->where('bulan', $progres->bulan)
                    ->where('minggu', $progres->minggu)
                    ->first();

                if ($rencana) {
                    $deviasi = $rencana->fisik - ($progres->nilai ?? 0);
                    $item->status_deviasi = $deviasi;
                }

                return $item;
            });


            return response()->json([
                'success' => true,
                'message' => 'Get Dashboard Data Success',
                'data' => $fisik
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
