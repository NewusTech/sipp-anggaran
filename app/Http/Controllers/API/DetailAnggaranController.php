<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use App\Models\Dokumentasi;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                    'nilai_kontrak',
                    'awal_kontrak',
                    'akhir_kontrak',
                    'target',
                    'kegiatan_id',
                )
                ->with(['kegiatan' => function ($query) {
                    $query->select('id', 'title', 'bidang_id', 'alokasi', 'tahun', 'program')
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

    public function getPenanggungJawab($detail_kegitan_id)
    {
        try {
            $detail_kegiatan = DetailKegiatan::select('id', 'penyedia_jasa', 'kegiatan_id', 'penanggung_jawab_id')
                ->with(['kegiatan' => function ($query) {
                    $query->select('id', 'title', 'bidang_id', 'program');
                }])
                ->where('id', $detail_kegitan_id)->first();

            if (!$detail_kegiatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $kegiatan = $detail_kegiatan->kegiatan;
            $kegiatan->penanggung_jawab = PenanggungJawab::select('id', 'pptk_name', 'pptk_nip', 'pptk_email', 'pptk_telpon', 'ppk_name', 'ppk_nip', 'ppk_email', 'ppk_telpon')
                ->with(
                    ['bidang_pptk' => function ($query) {
                        $query->select('id', 'name');
                    }],
                    ['bidang_ppk' => function ($query) {
                        $query->select('id', 'name');
                    }]
                )
                ->where('id', $detail_kegiatan->penanggung_jawab_id)->first();

            $data = [
                'detail_kegiatan' => $detail_kegiatan,
                'kegiatan' => $kegiatan
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

    public function getListPenanggungJawab()
    {
        try {
            $penanggung_jawab = PenanggungJawab::select('id', 'pptk_name')->get();

            return response()->json([
                'status' => 'success',
                'data' => $penanggung_jawab
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updatePenanggungJawab($detail_kegitan_id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'penanggung_jawab_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $penanggung_jawab = PenanggungJawab::where('id', $request->penanggung_jawab_id)->first();
            $detail_kegiatan = DetailKegiatan::where('id', $detail_kegitan_id);

            if (!$penanggung_jawab) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data penanggung jawab tidak ditemukan'
                ]);
            }

            if (!$detail_kegiatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data detail kegiatan tidak ditemukan'
                ]);
            }

            $detail_kegiatan->update([
                'penanggung_jawab_id' => $request->penanggung_jawab_id
            ]);

            return response()->json([
                'status' => 'success',
                'data' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function getDokumentasi($detail_kegitan_id)
    {
        try {
            $detail_kegiatan = DetailKegiatan::where('id', $detail_kegitan_id);


            if (!$detail_kegiatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data detail kegiatan tidak ditemukan'
                ]);
            }

            $dokumentasi = Dokumentasi::where('detail_kegiatan_id', $detail_kegitan_id)
                ->with('files')
                ->get();

            $data = [
                'detail_kegiatan' => $detail_kegiatan->first(),
                'dokumentasi' => $dokumentasi
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

    public function storeDokumentasi($detail_kegitan_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'keterangan' => 'required',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // dd($request->all());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $detail_kegiatan = DetailKegiatan::where('id', $detail_kegitan_id)->first();

            if (!$detail_kegiatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data detail kegiatan tidak ditemukan'
                ]);
            }

            $dokumentasi = Dokumentasi::create([
                'detail_kegiatan_id' => $detail_kegitan_id,
                'name' => $request->name,
                'keterangan' => $request->keterangan
            ]);

            foreach ($request->files as $file) {
                $filename = $file->getClientOriginalName();
                $type = $file->getMimeType();
                $path = 'file/dokumentasi/' . $filename;
                $fileDoc = $dokumentasi->files()->create([
                    'file_name' => $filename,
                    'path' => $path,
                    'type' => $type
                ]);

                if ($fileDoc) {
                    Storage::disk('local')->put($path, file_get_contents($file));
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateDokumentasi(Request $request, $detail_kegitan_id, $dokumen_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'keterangan' => 'required',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $detail_kegiatan = DetailKegiatan::where('id', $detail_kegitan_id)->first();

            if (!$detail_kegiatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data detail kegiatan tidak ditemukan'
                ]);
            }

            $dokumentasi = Dokumentasi::where('id', $dokumen_id)->first();

            if (!$dokumentasi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data dokumentasi tidak ditemukan'
                ]);
            }

            $dokumentasi->update([
                'name' => $request->name,
                'keterangan' => $request->keterangan
            ]);

            $dokumentasi->files()->delete();

            foreach ($request->files as $file) {
                $filename = $file->getClientOriginalName();
                $type = $file->getMimeType();
                $path = 'file/dokumentasi/' . $filename;
                $fileDoc = $dokumentasi->files()->create([
                    'file_name' => $filename,
                    'path' => $path,
                    'type' => $type
                ]);

                if ($fileDoc) {
                    Storage::disk('local')->put($path, file_get_contents($file));
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deteletDokumentasi($detail_kegitan_id, $dokumen_id, Request $request)
    {
        try {
            $detail_kegiatan = DetailKegiatan::where('id', $detail_kegitan_id)->first();

            if (!$detail_kegiatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data detail kegiatan tidak ditemukan'
                ]);
            }

            $dokumentasi = Dokumentasi::where('id', $dokumen_id)->first();

            if (!$dokumentasi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data dokumentasi tidak ditemukan'
                ]);
            }

            $dokumentasi->files()->delete();
            $dokumentasi->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getTitikLokasi($detail_kegitan_id)
    {
        try {
            $detail = DetailKegiatan::where('id', $detail_kegitan_id)
                ->select(
                    'id',
                    'title',
                    'alamat',
                    'no_detail_kegiatan',
                    'nilai_kontrak',
                    'no_kontrak',
                    'jenis_pengadaan',
                    'penyedia_jasa',
                    'latitude',
                    'longitude',
                    'penanggung_jawab_id',
                    'kegiatan_id',
                )
                ->with(
                    ['kegiatan' => function ($query) {
                        $query->select('id', 'title', 'bidang_id', 'alokasi', 'program')
                            ->with(['program' => function ($query) {
                                $query->select('id', 'name');
                            }]);
                    }],
                    'penyedia'
                )
                ->first();

            $detail->penanggung_jawab = PenanggungJawab::where('id', $detail->penanggung_jawab_id)
                ->select(
                    'id',
                    'pptk_name',
                    'pptk_email',
                    'pptk_telpon',
                    'ppk_name',
                    'ppk_email',
                    'ppk_telpon'
                )
                ->first();

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $data = [
                'detail_kegiatan' => $detail,
                'lokasi' => [
                    'latitude' => $detail->latitude,
                    'longitude' => $detail->longitude
                ]

            ];
            // }], 'subKegiatan', 'sumberDana', 'penyediaJasa', 'penanggungJawab')->first();
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

    public function updateLokasi($detail_kegitan_id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }
        try {
            $detail = DetailKegiatan::where('id', $detail_kegitan_id)->first();

            if (!$detail) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $detail->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);


            return response()->json([
                'status' => 'success',
                'data' => 'Lokasi berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
