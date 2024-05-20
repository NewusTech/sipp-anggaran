<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\DetailKegiatan;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use App\Exports\PaketFisikExport;
use App\Exports\PaketNonFisikExport;
use App\Exports\PaketKegiatanExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
				$bidang_id = null;
				$role = Auth::user()->getRoleNames();
				if (str_contains($role[0], "Staff")) {
					$bidang_id = Auth::user()->bidang_id;
				}
        $total_pagu = Kegiatan::where('is_arship', 0)->filter($request)->sum('alokasi');
        $total_realisasi = DetailKegiatan::whereHas('kegiatan', function ($query) use ($bidang_id) {
          $query->where('is_arship', 0);
          if ($bidang_id) {
            $query->where('bidang_id', $bidang_id);
          }
        })->filter($request)->sum('realisasi');
        $total_sisa = $total_pagu - $total_realisasi;
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
        ->filter($request)
        ->get();
        $nonfisik = DetailKegiatan::select(
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
            $query->where('jenis_paket', '2')->where('is_arship', 0);
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
        ->filter($request)
        ->get();
        $kegiatan = DetailKegiatan::select(
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
            $query->where('is_arship', 0);
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
        ->filter($request)
        ->get();
        $total_paket = DetailKegiatan::whereHas('kegiatan', function ($query) use ($bidang_id) {
          $query->where('is_arship', 0);
          if ($bidang_id) {
            $query->where('bidang_id', $bidang_id);
          }
        })
        ->filter($request)
        ->get()->count();
        $total_belum_mulai = DetailKegiatan::whereHas('kegiatan', function ($query) use ($bidang_id) {
          $query->where('is_arship', 0);
          if ($bidang_id) {
            $query->where('bidang_id', $bidang_id);
          }
        })->where('progress', '<=', 0)->filter($request)->get()->count();
        $total_mulai = DetailKegiatan::whereHas('kegiatan', function ($query) use ($bidang_id) {
          $query->where('is_arship', 0);
          if ($bidang_id) {
            $query->where('bidang_id', $bidang_id);
          }
        })->where('progress', '>', 0)->where('progress', '<', 100)->filter($request)->get()->count();
        $total_selesai = DetailKegiatan::whereHas('kegiatan', function ($query) use ($bidang_id) {
          $query->where('is_arship', 0);
          if ($bidang_id) {
            $query->where('bidang_id', $bidang_id);
          }
        })->where('progress', '>=', 100)->filter($request)->get()->count();
        return view('backend.dashboard.index', compact(['total_pagu','total_realisasi','total_sisa','fisik','nonfisik','kegiatan','total_paket','total_belum_mulai','total_mulai','total_selesai']));
    }

		public function chartData(Request $request)
    {
      $year = date('Y'); // Ambil tahun sekarang
      if (request()->has('tahun')) {
        if (!empty($request->tahun)) {
          $year = $request->tahun;
        }
      }
      $chartData = Anggaran::selectRaw('SUM(daya_serap_kontrak) as total, MONTH(tanggal) as month, daya_serap, keterangan')
      ->whereYear('tanggal', $year)
      ->groupBy(DB::raw('MONTH(tanggal)'))
      ->get();

      return response()->json($chartData);
    }
		public function mapsData(Request $request)
    {
      $bidang_id = null;
      $role = Auth::user()->getRoleNames();
      if (str_contains($role[0], "Staff")) {
        $bidang_id = Auth::user()->bidang_id;
      }
      $mapsData = DetailKegiatan::select('alamat', 'latitude', 'longitude', 'progress')->filter($request)->whereHas('kegiatan', function ($query) use ($bidang_id){
        $query->where('is_arship', 0);
        if ($bidang_id) {
          $query->where('bidang_id', $bidang_id);
        }
      })->orderBy('created_at','desc')->get();
      $resultMaps = [];
      foreach ($mapsData as $key => $value) {
        $resultMaps[$key] = [
          'name' => $value->alamat,
          'location' => [$value->latitude, $value->longitude],
          'progress' => $value->progress
        ];
      }
      return response()->json($resultMaps);
    }

    public function downloadPaketFisik(Request $request) 
		{
				return Excel::download(new PaketFisikExport($request), 'paket_fisik_'.date('Y-m-d').'.xlsx');
		}

    public function downloadPaketNonFisik(Request $request) 
		{
				return Excel::download(new PaketNonFisikExport($request), 'paket_non_fisik_'.date('Y-m-d').'.xlsx');
		}

    public function downloadPaketKegiatan(Request $request) 
		{
				return Excel::download(new PaketKegiatanExport($request), 'paket_kegiatan_'.date('Y-m-d').'.xlsx');
		}
}
