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
use App\Models\PenyediaJasa;
use App\Models\ProgresKegiatan;
use App\Models\PenanggungJawab;
use App\Models\RencanaKegiatan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bidang_id = [];
        $role = Auth::user()->getRoleNames();
        if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang")) {
            array_push($bidang_id, Auth::user()->bidang_id);
        }

        $kegiatan = Kegiatan::whereIn('bidang_id', $bidang_id)->get(['id']);
        $kegiatan = $kegiatan->map(function ($item) {
            return $item->id;
        });
        $detailKegiatan = DetailKegiatan::whereIn('kegiatan_id', $kegiatan)->sum('pagu');
        $total_pagu = $bidang_id == null ? DetailKegiatan::all()->sum('pagu') : DetailKegiatan::whereIn('kegiatan_id', $kegiatan)->sum('pagu');
        $kegiatan_id = Kegiatan::whereIn('bidang_id', $bidang_id)->pluck('id');
        $detail_kegiatan = DetailKegiatan::select(
            'title',
            'no_kontrak',
            'jenis_pengadaan',
            'nilai_kontrak',
            'progress',
            'awal_kontrak',
            'akhir_kontrak',
            'penyedia_jasa',
            'no_spmk',
            'latitude',
            'longitude'
        )->where('latitude', '!=', null)->where('longitude', '!=', null)->get();
        $total_realisasi = ProgresKegiatan::whereIn('detail_kegiatan_id', $detail_kegiatan->pluck('id'))
            ->where('jenis_progres', 'keuangan')->sum('nilai');
        if ($bidang_id == null) {
            $total_realisasi = ProgresKegiatan::where('jenis_progres', 'keuangan')->sum('nilai');
        }
        // dd($total_realisasi);
        $total_sisa = $total_pagu - $total_realisasi;
        // dd(Auth::user()->bidang_id, $bidang_id);
        $fisik = DetailKegiatan::select(
            'detail_kegiatan.id as detail_kegiatan_id',
            'detail_kegiatan.title',
            'detail_kegiatan.progress',
            'detail_kegiatan.akhir_kontrak',
            'detail_kegiatan.latitude',
            'detail_kegiatan.longitude',
            'detail_kegiatan.kegiatan_id',
            'bidang.name as bidang_name',
            'penanggung_jawab_id',
            'penyedia_jasa.name as penyedia_jasa'
        )->with('kegiatan', 'penanggungJawab')
            ->whereHas('kegiatan', function ($query) use ($bidang_id) {
                $query->where('is_arship', 0);
                if ($bidang_id != null && count($bidang_id) > 0) {
                    $query->whereIn('bidang_id', $bidang_id);
                }
            })
            ->leftJoin('kegiatan', function ($join) {
                $join->on('detail_kegiatan.kegiatan_id', '=', 'kegiatan.id');
            })
            ->leftJoin('penyedia_jasa', function ($join) {
                $join->on('detail_kegiatan.penyedia_jasa_id', '=', 'penyedia_jasa.id');
            })
            ->leftJoin('bidang', function ($join) {
                $join->on('kegiatan.bidang_id', '=', 'bidang.id');
            })
            ->filter($request)
            ->get();

            if ($role[0] == 'Pengawas') {
                $pengawas = PenanggungJawab::where('pptk_email', Auth::user()->email)->first('id');
                $fisik = $fisik->where('penanggung_jawab_id', $pengawas->id);
            }

        $progresFisik = ProgresKegiatan::where('jenis_progres', 'fisik')->whereIn('detail_kegiatan_id', $fisik->pluck('detail_kegiatan_id'))->orderBy('nilai', 'desc')->get();
        $rencanaFisik = RencanaKegiatan::whereIn('detail_kegiatan_id', $fisik->pluck('detail_kegiatan_id'))->get();
        $fisik->map(function ($item) use ($progresFisik, $rencanaFisik) {
            $progres = $progresFisik->where('detail_kegiatan_id', $item->detail_kegiatan_id);
            $rencana = $rencanaFisik->where('detail_kegiatan_id', $item->detail_kegiatan_id);
            $deviasi = ($rencana[$progres->count() - 1]->fisik ?? 0) - ($progres->first()->nilai ?? 0);
            $item->progress = $progres ?? 0;
            $item->rencana = $rencana ?? 0;
            $item->status_deviasi = $deviasi;
        });

        $total_paket = DetailKegiatan::whereHas('kegiatan', function ($query) use ($bidang_id) {
            $query->where('is_arship', 0);
            if ($bidang_id) {
                $query->whereIn('bidang_id', $bidang_id);
            }
        })
            ->filter($request)
            ->get()->count();

        $total_paket_belum_mulai =  DetailKegiatan::whereDoesntHave('progres')->whereHas('kegiatan', function ($query) use ($bidang_id) {
            if ($bidang_id) {
                $query->whereIn('bidang_id', $bidang_id);
            }
        })
            ->filter($request)
            ->get()
            ->count();

        $total_paket_dikerjakan = DetailKegiatan::whereHas('progres', function ($query) {
            $query->where('nilai', '>', 0);
        })->whereHas('kegiatan', function ($query) use ($bidang_id) {
            if ($bidang_id) {
                $query->whereIn('bidang_id', $bidang_id);
            }
        })->filter($request)
            ->get()
            ->count();

        $total_paket_selesai = DetailKegiatan::whereHas('progres', function ($query) {
            $query->where('nilai', '>=', 100);
        })->whereHas('kegiatan', function ($query) use ($bidang_id) {
            if ($bidang_id) {
                $query->whereIn('bidang_id', $bidang_id);
            }
        })->filter($request)
            ->with(['progres' => function ($query) {
                $query->select('id', 'detail_kegiatan_id', 'jenis_progres', 'nilai');
            }])
            ->get()->count();
        return view('backend.dashboard.index', compact(['total_pagu', 'total_realisasi', 'total_sisa', 'fisik', 'total_paket', 'total_paket_belum_mulai', 'total_paket_dikerjakan', 'total_paket_selesai', 'detail_kegiatan']));
    }

    public function chartData(Request $request)
    {
        $tahun = date('Y'); // Ambil tahun sekarang
        if ($request->has('tahun')) {
            if (!empty($request->tahun)) {
                $tahun = $request->tahun;
            }
        }
        $detailKegiatanIds = 1;

        // Ambil data total progres keuangan dan fisik per bulan berdasarkan tahun yang dipilih
        $role = Auth::user()->getRoleNames();
        $query = ProgresKegiatan::selectRaw('
                SUM(CASE WHEN jenis_progres = "keuangan" THEN nilai ELSE 0 END) as total_keuangan,
                SUM(CASE WHEN jenis_progres = "fisik" THEN nilai ELSE 0 END) as total_fisik,
                MONTH(tanggal) as bulan
            ')
            ->whereYear('tanggal', $tahun)
            ->groupBy(DB::raw('MONTH(tanggal)'));
        if ($role[0] == 'Kontraktor') {
            $penyediaJasa = $this->getIdKontraktor($role);
            $detailKegiatanIds = DetailKegiatan::where('penyedia_jasa_id', $penyediaJasa)->pluck('id')->toArray();
            $query->whereIn('detail_kegiatan_id', $detailKegiatanIds);
        } elseif (str_contains($role[0], "Staff") || str_contains($role[0], "Bidang")) {
            // Untuk pengguna dengan peran 'Staff' atau 'Bidang'
            $kegiatan = Kegiatan::where('bidang_id', Auth::user()->bidang_id)->pluck('id')->toArray();
            $detailKegiatanIds = DetailKegiatan::whereIn('kegiatan_id', $kegiatan)->pluck('id')->toArray();
            $query->whereIn('detail_kegiatan_id', $detailKegiatanIds);
        }

        $chartData = $query->get();

        return response()->json($chartData);
    }
    private function getIdKontraktor($role)
    {
        if (str_contains($role[0], "Kontraktor")) {
            $email = Auth::user()->email;
            $penyedia_jasa = PenyediaJasa::where('email', $email)->first();
            return $penyedia_jasa->id;
        }
    }
    public function mapsData(Request $request)
    {
        $bidang_id = null;
        $role = Auth::user()->getRoleNames();
        if (str_contains($role[0], "Staff")) {
            $bidang_id = Auth::user()->bidang_id;
        }
        $mapsData = DetailKegiatan::select('alamat', 'latitude', 'longitude', 'progress')->filter($request)->whereHas('kegiatan', function ($query) use ($bidang_id) {
            $query->where('is_arship', 0);
            if ($bidang_id) {
                $query->where('bidang_id', $bidang_id);
            }
        })->orderBy('created_at', 'desc')->get();
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
        return Excel::download(new PaketFisikExport($request), 'paket_fisik_' . date('Y-m-d') . '.xlsx');
    }

    public function downloadPaketNonFisik(Request $request)
    {
        return Excel::download(new PaketNonFisikExport($request), 'paket_non_fisik_' . date('Y-m-d') . '.xlsx');
    }

    public function downloadPaketKegiatan(Request $request)
    {
        return Excel::download(new PaketKegiatanExport($request), 'paket_kegiatan_' . date('Y-m-d') . '.xlsx');
    }
}
