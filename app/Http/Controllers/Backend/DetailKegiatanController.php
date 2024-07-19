<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DetailKegiatan\StoreDetailKegiatanRequest;
use App\Http\Requests\Backend\DetailKegiatan\UpdateDetailAnggaranRequest;
use App\Http\Requests\Backend\DetailKegiatan\UpdateDetailKegiatanRequest;
use App\Models\DetailKegiatan;
use App\Models\Kegiatan;
use App\Models\RencanaKegiatan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;

class DetailKegiatanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        try {
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

            $kegiatan = Kegiatan::where('id', $request->kegiatan_id)->first();

            $kegiatan->update([
                'tahun' => $request->tahun,
                'jenis_pengadaan' => $request->jenis_pengadaan
            ]);

            return redirect()->route('backend.kegiatan.index')->with('success', 'Detail Kegiatan berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->route('backend.kegiatan.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDetailKegiatanRequest $request
     * @param DetailKegiatan $detailKegiatan
     * @return RedirectResponse
     */

    public function updateVerifikasi(UpdateDetailKegiatanRequest $request, DetailKegiatan $detailKegiatan): RedirectResponse
    {
        $filteredRequest = array_filter($request->only([
            'verifikasi_admin',
            'komentar_admin',
            'verifikasi_pengawas',
            'komentar_pengawas'
        ]));
        $detailKegiatan->update($filteredRequest);
        return redirect()->route('backend.kegiatan.index')->with('success', 'Data Detail Kegiatan berhasil diubah');
    }
    public function update(UpdateDetailKegiatanRequest $request, DetailKegiatan $detailKegiatan): RedirectResponse
    {
        if ($detailKegiatan->update([
            'title' => $request->title,
            'no_kontrak' => $request->no_kontrak,
            'no_spmk' => $request->no_spmk,
            'nilai_kontrak' => $request->nilai_kontrak,
            'jenis_pengadaan' => $request->jenis_pengadaan,
            'awal_kontrak' => $request->awal_kontrak,
            'akhir_kontrak' => $request->akhir_kontrak,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'target' => $request->target ?? null,
            'real' => $request->real ?? null,
            'dev' => $request->dev ?? null,
            'alamat' => $request->alamat ?? null,
            'kegiatan_id' => $request->kegiatan_id,
            'daya_serap_kontrak' => $request->daya_serap_kontrak ?? 0,
            'sisa_kontrak' => $request->sisa_kontrak ?? 0,
            'sisa_anggaran' => $request->sisa_anggaran ?? 0,
            'verifikasi_admin' => $request->verifikasi_admin,
            'komentar_admin' => $request->komentar_admin,
            'verifikasi_pengawas' => $request->verifikasi_pengawas,
            'komentar_pengawas' => $request->komentar_pengawas,
        ])) {
         return redirect()->route('backend.kegiatan.index')->with('success', 'Data Detail Kegiatan berhasil diubah');
        }
        return redirect()->route('backend.kegiatan.index')->with('error', 'Data Detail Kegiatan gagal diubah');
    }

    public function updatePengawas(Request $request, $detail_kegiatan_id)
    {
        // dd($request->all, $detail_kegiatan_id);
        $detail_kegiatan = DetailKegiatan::where('id', $detail_kegiatan_id);

        $detail_kegiatan->update([
            'penanggung_jawab_id' => $request->penanggung_jawab_id
        ]);

        if ($detail_kegiatan) {
            return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail_kegiatan_id])->with('success', 'Data Detail Kegiatan berhasil diubah')->with('tab', 'penanggung_jawab');
        }

        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail_kegiatan_id])->with('error', 'Data Detail Kegiatan gagal diubah')->with('tab', 'penanggung_jawab');
    }

    public function updateMapPoint(Request $request, $detail)
    {
        try {
            $detail = DetailKegiatan::where('id', $detail)->first();
            if ($detail->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ])) {
                return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail])->with('success', 'Data kurva berhasil diperbarui.')->with('tab', 'titik_lokasi');
            }
        } catch (\Throwable $th) {
            return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail])->with('error', $th->getMessage())->with('tab', 'titik_lokasi');
        }
        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail])->with('error', 'Data lokasi gagal diperbarui.')->with('tab', 'titik_lokasi');
    }

    public function updateDetail(Request $request, DetailKegiatan $detailKegiatan)
    {
        try {
            if ($detailKegiatan->update([
                'title' => $request->title,
                'no_detail_kegiatan' => $request->no_detail_kegiatan,
                'no_kontrak' => $request->no_kontrak,
                'no_spmk' => $request->no_spmk,
                'nilai_kontrak' => $request->nilai_kontrak,
                'jenis_pengadaan' => $request->jenis_pengadaan,
                'target' => $request->target,
                'awal_kontrak' => $request->awal_kontrak,
                'akhir_kontrak' => $request->akhir_kontrak,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'penyedia_jasa' => $request->penyedia_jasa,
                'alamat' => $request->alamat,
                'kegiatan_id' => $request->kegiatan_id,
            ])) {
                $startDate = Carbon::parse($request->awal_kontrak);
                $endDate = Carbon::parse($request->akhir_kontrak);

                // Hitung jumlah minggu antara startDate dan endDate
                $totalWeeks = ceil($startDate->diffInWeeks($endDate));

                $progressData = [];
                $currentMonth = $startDate->month;
                $weekInMonth = 1;

                for ($i = 0; $i < $totalWeeks; $i++) {
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

                return redirect()->route('backend.kegiatan.index')->with('success', 'Data Detail Anggaran berhasil diubah');
            }
            return redirect()->route('backend.kegiatan.index')->with('error', 'Data Detail Anggaran gagal diubah');
        } catch (Exception $exception) {
            return redirect()->route('backend.kegiatan.index')->with('error', 'Data Detail Anggaran gagal diubah');
        }
    }
    public function updateAnggaran(UpdateDetailAnggaranRequest $request, DetailKegiatan $detailKegiatan): RedirectResponse
    {
        if ($detailKegiatan->update([
            'target' => $request->target ?? null,
            'real' => $request->real ?? null,
            'dev' => $request->dev ?? null,
            'progress' => $request->progress ?? 0,
            'latitude' => $request->latitude ?? 0,
            'longitude' => $request->longitude ?? 0
        ])) {
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
            => $detailKegiatan->id])->with('success', 'Data Detail Anggaran berhasil diubah')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
        => $detailKegiatan->id])->with('error', 'Data Detail Anggaran gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DetailKegiatan $detailKegiatan
     * @return RedirectResponse
     */
    public function destroy(DetailKegiatan $detailKegiatan): RedirectResponse
    {
        if ($detailKegiatan->delete()) {
            return redirect()->route('backend.kegiatan.index')->with('success', 'Data Detail Kegiatan berhasil dihapus');
        }
        return redirect()->route('backend.kegiatan.index')->with('success', 'Data Detail Kegiatan gagal dihapus');
    }

    public function updateProgress(Request $request)
    {
        try {
            $detail = DetailKegiatan::where('detail_kegiatan_id', $request->detail_kegiatan_id)
                ->update([
                    'progress' => $request->progress
                ]);
            //return response
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil diupdate!',
                'data'    => $detail
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal diupdate!',
                'data'    => []
            ]);
        }
    }
}
