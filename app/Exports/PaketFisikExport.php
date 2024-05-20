<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKegiatan;
use Illuminate\Http\Request;

class PaketFisikExport implements FromView
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
		$fisik = DetailKegiatan::select(
			'detail_kegiatan.id as detail_kegiatan_id', 
			'detail_kegiatan.title',
			'detail_kegiatan.realisasi',
			'detail_kegiatan.updated_at',
			'detail_kegiatan.progress',
			'detail_kegiatan.akhir_kontrak',
			'bidang.name as bidang_name',
			'penanggung_jawab.pptk_name',
			'penyedia_jasa.name as penyedia_jasa'
			)
			->whereHas('kegiatan', function ($query) use ($bidang_id) {
				$query->where('jenis_paket', '1')->where('is_arship', 0);
				if ($bidang_id) {
					$query->where('bidang_id', $bidang_id);
				}
		})
		->leftJoin('penanggung_jawab', function($join) {
				$join->on('detail_kegiatan.kegiatan_id', '=', 'penanggung_jawab.kegiatan_id');
		})
		->leftJoin('kegiatan', function($join) {
			$join->on('detail_kegiatan.kegiatan_id', '=', 'kegiatan.id');
		})
		->leftJoin('penyedia_jasa', function($join) {
			$join->on('detail_kegiatan.penyedia_jasa_id', '=', 'penyedia_jasa.id');
		})
		->leftJoin('bidang', function($join) {
			$join->on('kegiatan.bidang_id', '=', 'bidang.id');
		})
		->filter($this->request)
		->get();
		return view('backend.exports.paket_fisik', [
				'fisik' => $fisik
		]);
	}
}
