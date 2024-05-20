<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Pengambilan\StorePengambilanRequest;
use App\Http\Requests\Backend\Pengambilan\UpdatePengambilanRequest;
use App\Models\Dpa;
use App\Models\Anggaran;
use App\Models\DetailKegiatan;
use App\Models\Dokumentasi;
use App\Models\Kegiatan;
use App\Models\PenanggungJawab;
use App\Models\Program;
use App\Models\Pengambilan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PengambilanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StorePengambilanRequest $request
     * @return RedirectResponse
     */
    public function store(StorePengambilanRequest $request): RedirectResponse
    {
				$detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
        $pengambilan = Pengambilan::updateOrCreate([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'bulan' => $request->bulan,
        ],
        [
            'detail_kegiatan_id' => $request->detail_kegiatan_id,
            'bulan' => $request->bulan,
            'belanja_operasi' => $request->belanja_operasi ?? 0,
						'belanja_modal' => $request->belanja_modal ?? 0,
						'belanja_tak_terduga' => $request->belanja_tak_terduga ?? 0,
						'belanja_transfer' => $request->belanja_transfer ?? 0,
            'keterangan' => $request->keterangan ?? null,
        ]);
				$totalbelanjaOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_operasi');
				$totalbelanjaModal = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_modal');
				$totalbelanjaTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_tak_terduga');
				$totalbelanjaTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_transfer');
				$totalPengambilan = $totalbelanjaOperasi + $totalbelanjaModal + $totalbelanjaTakTerduga + $totalbelanjaTransfer;
				$detailKegiatan->update([
          'realisasi' => $totalPengambilan
				]);
        if($pengambilan) {
            return redirect()->route('backend.rencana.pengambilan', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Pengambilan berhasil disimpan')->with('tab', 'pengambilan');
        }
        return redirect()->route('backend.rencana.pengambilan', ['detail_kegiatan_id'
        => $request->detail_kegiatan_id])->with('error', 'Data pengambilan gagal disimpan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePengambilanRequest $request
     * @return RedirectResponse
     */
    public function storeDpa(StorePengambilanRequest $request): RedirectResponse
    {
      // $dpa = Dpa::where('id', $request->dpa_id)->first();
      $pengambilan = Pengambilan::updateOrCreate([
        'dpa_id' => $request->dpa_id,
        'bulan' => $request->bulan,
      ],
      [
        'dpa_id' => $request->dpa_id,
        'detail_kegiatan_id' => $request->detail_kegiatan_id ?? 0,
        'bulan' => $request->bulan,
        'belanja_operasi' => $request->belanja_operasi ?? 0,
        'belanja_modal' => $request->belanja_modal ?? 0,
        'belanja_tak_terduga' => $request->belanja_tak_terduga ?? 0,
        'belanja_transfer' => $request->belanja_transfer ?? 0,
        'keterangan' => $request->keterangan ?? null,
      ]);
      // $totalbelanjaOperasi = Pengambilan::where('dpa_id', '=', $request->dpa_id)->sum('belanja_operasi');
      // $totalbelanjaModal = Pengambilan::where('dpa_id', '=', $request->dpa_id)->sum('belanja_modal');
      // $totalbelanjaTakTerduga = Pengambilan::where('dpa_id', '=', $request->dpa_id)->sum('belanja_tak_terduga');
      // $totalbelanjaTransfer = Pengambilan::where('dpa_id', '=', $request->dpa_id)->sum('belanja_transfer');
      // $totalPengambilan = $totalbelanjaOperasi + $totalbelanjaModal + $totalbelanjaTakTerduga + $totalbelanjaTransfer;
      // $dpa->update([
      //   'realisasi' => $totalPengambilan
      // ]);
      if($pengambilan) {
          return redirect()->route('backend.dpa.show', $request->dpa_id)->with('success', 'Data Pengambilan berhasil disimpan')->with('step', 'pengambilan');
      }
      return redirect()->route('backend.dpa.show', ['detail_kegiatan_id', $request->dpa_id])->with('error', 'Data pengambilan gagal disimpan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePengambilanRequest $request
     * @param Pengambilan $pengambilan
     * @return RedirectResponse
     */
    public function update(UpdatePengambilanRequest $request, Pengambilan $pengambilan): RedirectResponse
    {
				$detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
        if($pengambilan->where('bulan', $request->bulan)->update([
					'belanja_operasi' => $request->belanja_operasi,
					'belanja_modal' => $request->belanja_modal,
					'belanja_tak_terduga' => $request->belanja_tak_terduga,
					'belanja_transfer' => $request->belanja_transfer,
					'keterangan' => $request->keterangan ?? null,
        ])) {
					$totalbelanjaOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_operasi');
					$totalbelanjaModal = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_modal');
					$totalbelanjaTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_tak_terduga');
					$totalbelanjaTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_transfer');
					$totalPengambilan = $totalbelanjaOperasi + $totalbelanjaModal + $totalbelanjaTakTerduga + $totalbelanjaTransfer;
					$detailKegiatan->update([
						'realisasi' => $totalPengambilan
					]);
            return redirect()->route('backend.detail_anggaran.show', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Pengambilan berhasil diubah')->with('tab', 'pengambilan');
        }
        return redirect()->route('backend.detail_anggaran.show', ['detail_kegiatan_id'
        => $request->detail_kegiatan_id])->with('error', 'Data Pengambilan gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pengambilan $Pengambilan
     * @return RedirectResponse
     */
    public function destroy(Pengambilan $pengambilan): RedirectResponse
    {
			$detailId = $pengambilan->detail_kegiatan_id;
			$detailKegiatan = DetailKegiatan::where('id', $detailId)->first();
        if($pengambilan->delete()) {
					$totalbelanjaOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_operasi');
					$totalbelanjaModal = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_modal');
					$totalbelanjaTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_tak_terduga');
					$totalbelanjaTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('belanja_transfer');
					$totalPengambilan = $totalbelanjaOperasi + $totalbelanjaModal + $totalbelanjaTakTerduga + $totalbelanjaTransfer;
					$detailKegiatan->update([
						'realisasi' => $totalPengambilan
					]);
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
            => $pengambilan->detail_kegiatan_id])->with('success', 'Data Pengambilan berhasil dihapus')->with('tab', 'pengambilan');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
        => $pengambilan->detail_kegiatan_id])->with('error', 'Data Pengambilan gagal dihapus');
    }

    public function getPengambilan(Request $request)
    {
        $pengambilan = Pengambilan::where('detail_kegiatan_id', $request->detail_kegiatan_id)
        ->where('bulan', $request->bulan)
        ->orderBy('created_at', 'desc')
        ->first();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil diambil!',
            'data'    => $pengambilan  
        ]);
    }

    public function getPengambilanByDpa(Request $request)
    {
        $pengambilan = Pengambilan::where('dpa_id', $request->dpa_id)
        ->where('bulan', $request->bulan)
        ->orderBy('created_at', 'desc')
        ->first();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil diambil!',
            'data'    => $pengambilan  
        ]);
    }
}
