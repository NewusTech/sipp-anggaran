<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dpa;
use App\Models\Pagu;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\Pengambilan;
use App\Models\DetailKegiatan;
use App\Models\Anggaran;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class SubKegiatanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(Request $request, $id)
    {
        $subKegiatan = SubKegiatan::create([
					'dpa_id' => $id,
					'kegiatan_id' => $request->kegiatan_id,
					'detail_kegiatan_id' => $request->detail_kegiatan_id,
					'sumber_dana_id' => $request->sumber_dana_id,
        ]);
				$sub = SubKegiatan::where('id', $subKegiatan->id)->first();
        $pagu = Pagu::create(
        [
          'dpa_id' => $id,
          'kegiatan_id' => $request->kegiatan_id,
          'sub_kegiatan_id' => $sub->id,
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
					'tanggal' => $request->tanggal,
					'belanja_operasi' => $request->belanja_operasi ?? 0,
					'belanja_modal' => $request->belanja_modal ?? 0,
					'belanja_tak_terduga' => $request->belanja_tak_terduga ?? 0,
					'belanja_transfer' => $request->belanja_transfer ?? 0,
					'keterangan' => $request->keterangan ?? null,
        ]);
				$totalbelanjaOperasi = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_operasi');
				$totalbelanjaModal = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_modal');
				$totalbelanjaTakTerduga = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_tak_terduga');
				$totalbelanjaTransfer = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_transfer');
				$totalPagu = $totalbelanjaOperasi + $totalbelanjaModal + $totalbelanjaTakTerduga + $totalbelanjaTransfer;
				$sub->update([
          'total_pagu' => $totalPagu
				]);
				$totalRealisasi = SubKegiatan::where('dpa_id', '=', $id)->sum('total_pagu');
				$dpa = Dpa::where('id', '=', $id)->update([
					'realisasi' => $totalRealisasi
				]);
				$detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
        $belanjaOperasi = Anggaran::updateOrCreate([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Operasi",
        ],
        [
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Operasi",
          'sisa' => 0,
          'tanggal' => $request->tanggal,
          'keterangan' => $request->keterangan ?? null,
          'daya_serap_kontrak' => $request->belanja_operasi ?? 0,
          'sisa_kontrak' => $request->sisa_kontrak ?? 0,
          'sisa_anggaran' => $request->sisa_anggaran ?? 0,
          'progress' => 0
        ]);
				$belanjaModal = Anggaran::updateOrCreate([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Modal",
        ],
        [
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Modal",
          'sisa' => 0,
          'tanggal' => $request->tanggal,
          'keterangan' => $request->keterangan ?? null,
          'daya_serap_kontrak' => $request->belanja_modal ?? 0,
          'sisa_kontrak' => $request->sisa_kontrak ?? 0,
          'sisa_anggaran' => $request->sisa_anggaran ?? 0,
          'progress' => 0
        ]);
				$belanjaTakTerduga = Anggaran::updateOrCreate([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Tak Terduga",
        ],
        [
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Tak Terduga",
          'sisa' => 0,
          'tanggal' => $request->tanggal,
          'keterangan' => $request->keterangan ?? null,
          'daya_serap_kontrak' => $request->belanja_tak_terduga ?? 0,
          'sisa_kontrak' => $request->sisa_kontrak ?? 0,
          'sisa_anggaran' => $request->sisa_anggaran ?? 0,
          'progress' => 0
        ]);
				$belanjaTransfer = Anggaran::updateOrCreate([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Transfer",
        ],
        [
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => "Belanja Transfer",
          'sisa' => 0,
          'tanggal' => $request->tanggal,
          'keterangan' => $request->keterangan ?? null,
          'daya_serap_kontrak' => $request->belanja_transfer ?? 0,
          'sisa_kontrak' => $request->sisa_kontrak ?? 0,
          'sisa_anggaran' => $request->sisa_anggaran ?? 0,
          'progress' => 0
        ]);
				$totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('daya_serap_kontrak');
				$detailKegiatan->update([
          'pagu' => $totalDayaSerap
				]);
        return redirect()->route('backend.dpa.show', $id)->with('success', 'Kegiatan berhasil disimpan')->with('step', 'sub_kegiatan');
    }

		/**
     * Update the specified resource in storage.
     *
     * @param UpdatePengambilanRequest $request
     * @param Pengambilan $pengambilan
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
				$sub = SubKegiatan::where('id', $id)->first();
				$sub->update([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'sumber_dana_id' => $request->sumber_dana_id,
        ]);
				$pagu = Pagu::where('kegiatan_id', $sub->kegiatan_id)->where('dpa_id', $sub->dpa_id)->where('sub_kegiatan_id', $sub->id)->first();
        if($pagu->update([
					'detail_kegiatan_id' => $request->detail_kegiatan_id,
					'sub_kegiatan_id' => $sub->id,
					'belanja_operasi' => $request->belanja_operasi,
					'belanja_modal' => $request->belanja_modal,
					'belanja_tak_terduga' => $request->belanja_tak_terduga,
					'belanja_transfer' => $request->belanja_transfer,
					'keterangan' => $request->keterangan ?? null,
        ])) {
					$totalbelanjaOperasi = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_operasi');
					$totalbelanjaModal = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_modal');
					$totalbelanjaTakTerduga = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_tak_terduga');
					$totalbelanjaTransfer = Pagu::where('sub_kegiatan_id', '=', $sub->id)->sum('belanja_transfer');
					$totalPagu = $totalbelanjaOperasi + $totalbelanjaModal + $totalbelanjaTakTerduga + $totalbelanjaTransfer;

					$sub->update([
						'total_pagu' => $totalPagu
					]);
					$totalRealisasi = SubKegiatan::where('dpa_id', '=', $sub->dpa_id)->sum('total_pagu');
					$dpa = Dpa::where('id', '=', $sub->dpa_id)->update([
						'realisasi' => $totalRealisasi
					]);
					$detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
					$belanjaOperasi = Anggaran::updateOrCreate([
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Operasi",
					],
					[
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Operasi",
						'sisa' => 0,
						'tanggal' => $request->tanggal,
						'keterangan' => $request->keterangan ?? null,
						'daya_serap_kontrak' => $request->belanja_operasi ?? 0,
						'sisa_kontrak' => $request->sisa_kontrak ?? 0,
						'sisa_anggaran' => $request->sisa_anggaran ?? 0,
						'progress' => 0
					]);
					$belanjaModal = Anggaran::updateOrCreate([
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Modal",
					],
					[
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Modal",
						'sisa' => 0,
						'tanggal' => $request->tanggal,
						'keterangan' => $request->keterangan ?? null,
						'daya_serap_kontrak' => $request->belanja_modal ?? 0,
						'sisa_kontrak' => $request->sisa_kontrak ?? 0,
						'sisa_anggaran' => $request->sisa_anggaran ?? 0,
						'progress' => 0
					]);
					$belanjaTakTerduga = Anggaran::updateOrCreate([
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Tak Terduga",
					],
					[
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Tak Terduga",
						'sisa' => 0,
						'tanggal' => $request->tanggal,
						'keterangan' => $request->keterangan ?? null,
						'daya_serap_kontrak' => $request->belanja_tak_terduga ?? 0,
						'sisa_kontrak' => $request->sisa_kontrak ?? 0,
						'sisa_anggaran' => $request->sisa_anggaran ?? 0,
						'progress' => 0
					]);
					$belanjaTransfer = Anggaran::updateOrCreate([
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Transfer",
					],
					[
						'detail_kegiatan_id' => $request->detail_kegiatan_id,
						'daya_serap' => "Belanja Transfer",
						'sisa' => 0,
						'tanggal' => $request->tanggal,
						'keterangan' => $request->keterangan ?? null,
						'daya_serap_kontrak' => $request->belanja_transfer ?? 0,
						'sisa_kontrak' => $request->sisa_kontrak ?? 0,
						'sisa_anggaran' => $request->sisa_anggaran ?? 0,
						'progress' => 0
					]);
					$totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('daya_serap_kontrak');
					$detailKegiatan->update([
						'pagu' => $totalDayaSerap
					]);
            return redirect()->route('backend.dpa.show', ['id'
            => $sub->dpa_id])->with('success', 'Data Sub Kegiatan berhasil diubah');
        }
        return redirect()->route('backend.dpa.show', ['id'
        => $sub->dpa_id])->with('error', 'Data Sub Kegiatan gagal diubah');
    }

		/**
     * Remove the specified resource from storage.
     *
     * @param Pengambilan $Pengambilan
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
			$sub = SubKegiatan::where('id', $id)->first();
			$pagu = Pagu::where('detail_kegiatan_id', $sub->detail_kegiatan_id)->first();
			$dpaId = $sub->dpa_id;
			if ($pagu->delete()) {
				$sub->delete();
				$totalRealisasi = SubKegiatan::where('dpa_id', '=', $dpaId)->sum('total_pagu');
				$dpa = Dpa::where('id', '=', $dpaId)->update([
					'realisasi' => $totalRealisasi
				]);
			}
			return redirect()->route('backend.dpa.show', ['id'
      => $dpaId])->with('success', 'Data Sub Kegiatan berhasil dihapus');
    }
}
