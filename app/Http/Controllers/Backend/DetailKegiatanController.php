<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\DetailKegiatan\StoreDetailKegiatanRequest;
use App\Http\Requests\Backend\DetailKegiatan\UpdateDetailAnggaranRequest;
use App\Http\Requests\Backend\DetailKegiatan\UpdateDetailKegiatanRequest;
use App\Models\DetailKegiatan;
use App\Models\RencanaKegiatan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DetailKegiatanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDetailKegiatanRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDetailKegiatanRequest $request): RedirectResponse
    {
        $detailKegiatan = DetailKegiatan::create([
            'title' => $request->title,
            'no_detail_kegiatan' => $request->no_detail_kegiatan,
            'no_kontrak' => $request->no_kontrak,
            'jenis_pengadaan' => $request->jenis_pengadaan,
            'nilai_kontrak' => 0,
            'pagu' => 0,
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
            'penyedia_jasa_id' => $request->penyedia_jasa_id,
            'progress' => 0
        ]);

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

        if ($detailKegiatan) {
            return redirect()->route('backend.kegiatan.index')->with('success', 'Detail Kegiatan berhasil disimpan');
        }

        return redirect()->route('backend.kegiatan.index')->with('error', 'Detail Kegiatan gagal disimpan');
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
            // dd($request->verifikasi_pengawas, $detailKegiatan->verifikasi_pengawas);
            return redirect()->route('backend.kegiatan.index')->with('success', 'Data Detail Kegiatan berhasil diubah');
        }
        return redirect()->route('backend.kegiatan.index')->with('error', 'Data Detail Kegiatan gagal diubah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDetailAnggaranRequest $request
     * @param DetailKegiatan $detailKegiatan
     * @return RedirectResponse
     */
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
