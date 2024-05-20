<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKegiatan;
use App\Models\Anggaran;
use App\Models\Pengambilan;
use Illuminate\Http\Request;

class LaporanPengambilanExport implements FromView
{

	public function __construct(Request $request)
	{
    $this->request = $request;
  }

	public function view(): View
	{
		$bidang_id = null;
		$role = Auth::user()->getRoleNames();
		if (str_contains($role[0], "Staff")) {
			$bidang_id = Auth::user()->bidang_id;
		}
		$details = DetailKegiatan::select('detail_kegiatan.title as sub_kegiatan_title',
		'detail_kegiatan.id',
		'detail_kegiatan.pagu',
		'kegiatan.title as kegiatan_title',
		'kegiatan.alokasi as alokasi',
		'program.name as program_title'
		)->filter($this->request)
		->leftJoin('kegiatan', function($join) {
			$join->on('detail_kegiatan.kegiatan_id', '=', 'kegiatan.id');
		})
		->leftJoin('program', function($join) {
			$join->on('kegiatan.program', '=', 'program.id');
		})
		->whereHas('kegiatan', function ($query) use ($bidang_id) {
			$query->where('is_arship', 0);
			if ($bidang_id) {
				$query->where('bidang_id', $bidang_id);
			}
		})->get();
		foreach ($details as $key => $detail) {
			$totalbelanjaOperasi = Anggaran::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Operasi')->sum('daya_serap_kontrak');
			$totalbelanjaModal = Anggaran::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Modal')->sum('daya_serap_kontrak');
			$totalbelanjaTakTerduga = Anggaran::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Tak Terduga')->sum('daya_serap_kontrak');
			$totalbelanjaTransfer = Anggaran::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Transfer')->sum('daya_serap_kontrak');
			$totalOperasi = Pengambilan::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_operasi');
			$totalModal = Pengambilan::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_modal');
			$totalTakTerduga = Pengambilan::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_tak_terduga');
			$totalTransfer = Pengambilan::filter($this->request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_transfer');
			$detail->anggaran_belanja_operasi = $totalbelanjaOperasi;
			$detail->anggaran_belanja_modal = $totalbelanjaModal;
			$detail->anggaran_belanja_tak_terduga = $totalbelanjaTakTerduga;
			$detail->anggaran_belanja_transfer = $totalbelanjaTransfer;
			$detail->pengambilan_belanja_operasi = $totalOperasi;
			$detail->pengambilan_belanja_modal = $totalModal;
			$detail->pengambilan_belanja_tak_terduga = $totalTakTerduga;
			$detail->pengambilan_belanja_transfer = $totalTransfer;
		}
		$tahun = $this->request->tahun;
		$bulan = $this->request->bulan;
			return view('backend.exports.laporan', [
					'details' => $details,
					'tahun' => $tahun,
					'bulan' => $bulan
			]);
	}
}
