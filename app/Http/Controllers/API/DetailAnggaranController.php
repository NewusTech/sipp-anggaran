<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailAnggaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function detail($detail_kegitan_id)
    {
        try {
            $detail = DetailKegiatan::where('id', $detail_kegitan_id)
                ->select(
                    'id',
                    'title',
                    'no_detail_kegiatan',
                    'no_kontrak',
                    'jenis_pengadaan',
                    'penyedia_jasa',
                    'no_spmk',
                    'realisasi',
                    'awal_kontrak',
                    'akhir_kontrak',
                    'target',
                    'kegiatan_id',
                )
                ->with(['kegiatan' => function ($query) {
                    $query->select('id', 'title', 'bidang_id', 'alokasi', 'program')
                        ->with(['program' => function ($query) {
                            $query->select('id', 'name');
                        }]);
                }])
                ->first();
            // }], 'subKegiatan', 'sumberDana', 'penyediaJasa', 'penanggungJawab')->first();
            return response()->json([
                'status' => 'success',
                'data' => $detail
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function kurfaFisik($detail_kegitan_id)
    {
        try {
            $detail = DetailKegiatan::find($detail_kegitan_id);

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $chartDatafisik = $detail->progres()->where('jenis_progres', 'fisik')->get()->groupBy('bulan')->map(function ($items, $bulan) {
                return $items->sum('nilai');
            });

            $chartDataRencana = $detail->rencana_kegiatans->groupBy('bulan')->map(function ($items, $bulan) {
                return $items->sum('fisik');
            });


            $chartDatafisik = $chartDatafisik->toArray();
            $chartDataRencana = $chartDataRencana->toArray();

            $data = [
                'chart' => [
                    'labels' => array_keys($chartDatafisik),
                    'data_fisik' => array_values($chartDatafisik),
                    'data_rencana' => array_values($chartDataRencana)
                ],
                'data' => [
                    'realisasi_fisik' => $detail->progres()->where('jenis_progres', 'fisik')->get(),
                    'rencana_fisik' =>  $detail->rencana_kegiatans
                ]
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateProgresFisik($detail_kegitan_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }
        try {
            $detail = DetailKegiatan::find($detail_kegitan_id);

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $err_data = [];

            foreach ($request->data as $key => $value) {
                $progress = $detail->progres()->where('id', $key)->where('jenis_progres', 'fisik')
                    ->update(['nilai' => $value]);

                if (!$progress) {
                    $err_data[] = 'Data dengan id ' . $key . ' tidak ditemukan';
                }
            }

            if (count($err_data) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $err_data
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
                'data' => $detail->progres()->where('jenis_progres', 'fisik')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function updateRencanaFisik($detail_kegitan_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }
        try {
            $detail = DetailKegiatan::find($detail_kegitan_id);

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $err_data = [];

            foreach ($request->data as $key => $value) {
                $rencana_kegiatan = $detail->rencana_kegiatans()->where('id', $key)->update(['fisik' => $value]);

                if (!$rencana_kegiatan) {
                    $err_data[] = 'Data dengan id ' . $key . ' tidak ditemukan';
                }
            }

            if (count($err_data) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $err_data
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
                'data' => $detail->rencana_kegiatans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function kurfaKeuangan($detail_kegitan_id)
    {
        try {
            $detail = DetailKegiatan::find($detail_kegitan_id);

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $chartData = $detail->progres()->where('jenis_progres', 'keuangan')->get()->groupBy('bulan')->map(function ($items, $bulan) {
                return $items->sum('nilai');
            });

            $chartData = $chartData->toArray();

            $data = [
                'chart' => [
                    'labels' => array_keys($chartData),
                    'data_Keuangan' => array_values($chartData),
                ],
                'data' => [
                    'relaisasi_keuangan' => $detail->progres()->where('jenis_progres', 'keuangan')->get(),
                ]
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateProgresKeuangan($detail_kegitan_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'data.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $detail = DetailKegiatan::find($detail_kegitan_id);

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $err_data = [];

            foreach ($request->data as $key => $value) {
                $progress = $detail->progres()->where('id', $key)->where('jenis_progres', 'keuangan')
                    ->update(['nilai' => $value]);

                if (!$progress) {
                    $err_data[] = 'Data dengan id ' . $key . ' tidak ditemukan';
                }
            }

            if (count($err_data) > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $err_data
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
                'data' => $detail->progres()->where('jenis_progres', 'keuangan')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
