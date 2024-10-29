<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\ProgresKegiatan;
use App\Models\RencanaKegiatan;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class DetailKegitanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }


    public function getKegiatanAndSubKegiatan(Request $request)
    {
        try {
            $kegiatan = Kegiatan::select('id', 'title')
                ->with('subKegiatan:id,kegiatan_id,title')
                ->get();
            // $subKegiatan = DetailKegiatan::select('id', 'title')->get();

            return response()->json([
                'success' => true,
                'message' => 'Get Kegiatan and Sub Kegiatan Success',
                'data' => [
                    'kegiatan' => $kegiatan,
                    // 'sub_kegiatan' => $subKegiatan
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getBidangAndSumberDana()
    {
        try {
            $bidang = Bidang::select('id', 'name', 'kode')->get();
            $sumberDana = SumberDana::select('id', 'name')->get();

            $data = [
                'bidang' => $bidang,
                'sumber_dana' => $sumberDana
            ];

            return response()->json([
                'success' => true,
                'message' => 'Get Kegiatan Success',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => ['required', 'numeric', 'exists:kegiatan,id'],
            'sub_kegiatan_id' => ['required', 'numeric', 'exists:sub_kegiatan,id'],
            'pagu' => ['nullable', 'numeric'],
            'title' => ['required', 'string'],
            'tahun' => ['required', 'numeric', 'digits:4'],
            'jenis_pengadaan' => ['required', 'string'],
            'metode_pemilihan' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $kegiatan = Kegiatan::where('id', $request->kegiatan_id)->first();
            $subKegiatan = SubKegiatan::where('id', $request->sub_kegiatan_id)->first();

            if (!$kegiatan || !$subKegiatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kegiatan Not Found',
                ], 404);
            }

            $detailKegiatan = DetailKegiatan::create([
                'title' => $request->title,
                'no_detail_kegiatan' => 1,
                'no_kontrak' => '-',
                'jenis_pengadaan' => $request->jenis_pengadaan,
                'nilai_kontrak' => 0,
                'pagu' => $request->pagu ?? 0,
                'awal_kontrak' => Date::now(),
                'akhir_kontrak' => Date::now(),
                'sub_kegiatan_id' => $request->sub_kegiatan_id,
                'metode_pemilihan' => $request->metode_pemilihan,
                'kegiatan_id' => $request->kegiatan_id,
            ]);


            $kegiatan->update([
                'tahun' => $request->tahun,
                'jenis_pengadaan' => $request->jenis_pengadaan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detail Kegiatan Created',
                'data' => $detailKegiatan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($detail_kegitan_id)
    {
        try {
            $detailKegiatan = DetailKegiatan::where('id', $detail_kegitan_id)
                ->select([
                    'id',
                    'title',
                    'no_detail_kegiatan',
                    'no_kontrak',
                    'no_spmk',
                    'nilai_kontrak',
                    'jenis_pengadaan',
                    'awal_kontrak',
                    'akhir_kontrak',
                    'penyedia_jasa',
                    'target',
                    'alamat'
                ])
                ->first();

            if (!$detailKegiatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail Kegiatan Not Found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Get Detail Kegiatan Success',
                'data' => $detailKegiatan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    public function update(Request $request, $detail_kegitan_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'no_detail_kegiatan' => ['required', 'numeric'],
            'no_kontrak' => ['required', 'string'],
            'no_spmk' => ['required', 'string'],
            'nilai_kontrak' => ['required', 'numeric'],
            'jenis_pengadaan' => ['required', 'string'],
            'awal_kontrak' => ['required', 'date'],
            'akhir_kontrak' => ['required', 'date'],
            'penyedia_jasa' => ['required', 'string'],
            'target' => ['required', 'numeric'],
            'alamat' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $detailKegiatan = DetailKegiatan::with('progres', 'rencana_kegiatans')->where('id', $detail_kegitan_id)
                ->select([
                    'id',
                    'title',
                    'no_detail_kegiatan',
                    'no_kontrak',
                    'no_spmk',
                    'nilai_kontrak',
                    'jenis_pengadaan',
                    'awal_kontrak',
                    'akhir_kontrak',
                    'penyedia_jasa',
                    'target',
                    'alamat'
                ])
                ->first();

            if (!$detailKegiatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail Kegiatan Not Found',
                ], 404);
            }

            $detailKegiatan->update([
                'title' => $request->title,
                'no_detail_kegiatan' => $request->no_detail_kegiatan,
                'no_kontrak' => $request->no_kontrak,
                'no_spmk' => $request->no_spmk,
                'nilai_kontrak' => $request->nilai_kontrak,
                'jenis_pengadaan' => $request->jenis_pengadaan,
                'awal_kontrak' => $request->awal_kontrak,
                'akhir_kontrak' => $request->akhir_kontrak,
                'penyedia_jasa' => $request->penyedia_jasa,
                'target' => $request->target,
                'alamat' => $request->alamat,
            ]);

            $startDate = Carbon::parse($request->awal_kontrak);
            $endDate = Carbon::parse($request->akhir_kontrak);

            $existingProgress = RencanaKegiatan::where('detail_kegiatan_id', $detailKegiatan->id)
                ->delete();

            if ($detailKegiatan->progres()->exists()) {
                $detailKegiatan->progres()->delete();
            }

            $totalDays = $startDate->diffInDays($endDate);
            $totalWeeks = (int)ceil($totalDays / 7);

            $progressData = [];
            $currentMonth = $startDate->month;
            $weekInMonth = 1;

            for ($i = 0; $i < $totalWeeks; $i++) {

                $detailKegiatan->progres()->create([
                    'tanggal' => Carbon::now(),
                    'jenis_progres' => 'fisik',
                    'nilai' => 0,
                    'bulan' => $startDate->format('Y-m'),
                    'minggu' => $weekInMonth,
                ]);

                $detailKegiatan->progres()->create([
                    'tanggal' => Carbon::now(),
                    'jenis_progres' => 'keuangan',
                    'nilai' => 0,
                    'bulan' => $startDate->format('Y-m'),
                    'minggu' => $weekInMonth,
                ]);
                $progressData[] = [
                    'detail_kegiatan_id' => $detailKegiatan->id,
                    'bulan' => $startDate->format('Y-m'),
                    'minggu' => $weekInMonth,
                    'keuangan' => 0,
                ];

                $startDate->addWeek();

                if ($startDate->month !== $currentMonth) {
                    $currentMonth = $startDate->month;
                    $weekInMonth = 1;
                } else {
                    $weekInMonth++;
                }
            }
            RencanaKegiatan::insert($progressData);

            return response()->json([
                'success' => true,
                'message' => 'Detail Kegiatan updated',
                'data' => $detailKegiatan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy($detail_kegitan_id)
    {
        try {
            $detailKegiatan = DetailKegiatan::where('id', $detail_kegitan_id)->first();

            if (!$detailKegiatan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail Kegiatan Not Found',
                ], 404);
            }

            $detailKegiatan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detail Kegiatan Deleted',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
