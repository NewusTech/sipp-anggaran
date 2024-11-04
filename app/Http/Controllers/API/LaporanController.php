<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\PenyediaJasa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function getBidang()
    {
        try {
            $bidang = Bidang::select('id', 'name')->get();
            return response()->json([
                'status' => 'success',
                'data' => $bidang
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index(Request $request)
    {
        $request_bidang_id = $request->bidang;
        $request_tahun = $request->tahun;
        $request_bulan = $request->bulan;
        $request_search = $request->search;

        $bidang_id = null;

        try {
            $user = auth('api')->user();

            $user_role = $user->getRoleNames();
            $bidang_id_kontraktor = null;
            $kegiatan_id = Kegiatan::pluck('id');
            if (str_contains($user_role[0], 'kontraktor')) {
                $penyedia_jasa = PenyediaJasa::where('email', $user->email)->first();
                $bidang_id_kontraktor = $penyedia_jasa->detailKegiatan->kegiatan->bidang->id;
            }

            if (str_contains($user_role[0], 'Staff') || str_contains($user_role[0], 'Kepala Bidang') || str_contains($user_role[0], 'Kontraktor')) {
                $bidang_id = $user->bidang_id;
                if (str_contains($user_role[0], 'Kontraktor')) {
                    $bidang_id = $bidang_id_kontraktor;
                }
            }

            if ($request_bidang_id) {
                $bidang_id = $request_bidang_id;
            }

            $data = Bidang::with(['kegiatan' => function ($query) use ($request_search, $request_tahun, $request_bulan) {
                if ($request_search) {
                    $query->where('nama', 'like', '%' . $request_search . '%');
                }

                if ($request_tahun) {
                    $query->whereYear('created_at', $request_tahun);
                }

                if ($request_bulan) {
                    $query->whereMonth('created_at', $request_bulan)
                        ->whereYear('created_at', $request_tahun ?? date('Y')); // Default to current year if no year is specified
                }

                $query->with('detail.progres');
            }])->where('id', $bidang_id)->get();


            if ($bidang_id == null) {
                $data = Bidang::with('kegiatan.detail.progres')->get();
            }

            $data->map(function ($bidang) {
                $bidang->kegiatan->map(function ($kegiatan) {
                    $total_keuangan_kegiatan = 0;
                    $kegiatan->detail->map(function ($detail) use (&$total_keuangan_kegiatan) {
                        $detail->total_keuangan = $detail->progres->where('jenis_progres', 'keuangan')->sum('nilai');
                        $detail->total_fisik = $detail->progres->where('jenis_progres', 'fisik')->sum('nilai');
                        $total_keuangan_kegiatan += $detail->total_keuangan;
                        $detail->progres->map(function ($progres) use ($detail) {
                            $detail->progress = $progres->orderBy('nilai', 'desc')->first()->nilai;
                        });
                    });
                    $kegiatan->sisa = $kegiatan->alokasi - $total_keuangan_kegiatan;
                });
            });

            $kegiatan = Kegiatan::whereIn('id', $kegiatan_id->toArray())->get();
            $details = $user_role[0] == 'Kontraktor' ? DetailKegiatan::with('progres')->where('penyedia_jasa_id', $penyedia_jasa->id)->get() : DetailKegiatan::with('progres')->whereIn('kegiatan_id', $kegiatan_id->toArray())->get();

            $return_data = [
                'bidang' => $data,
                // 'kegiatan' => $kegiatan,
                // 'details' => $details
            ];

            return response()->json([
                'status' => 'success',
                'data' => $return_data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
