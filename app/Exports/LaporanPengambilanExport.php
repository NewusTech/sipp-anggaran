<?php

namespace App\Exports;

use App\Models\Kegiatan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKegiatan;
use App\Models\Anggaran;
use App\Models\Bidang;
use App\Models\Pengambilan;
use App\Models\PenyediaJasa;
use Illuminate\Http\Request;

class LaporanPengambilanExport implements FromView
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    private function getIdBidangKontraktor($role)
    {
        if (str_contains($role[0], "Kontraktor")) {
            $email = Auth::user()->email;
            $penyedia_jasa = PenyediaJasa::where('email', $email)->first();
            $kegiatan_id = DetailKegiatan::where('penyedia_jasa_id', $penyedia_jasa->id)->first()->kegiatan_id;
            return Kegiatan::where('id', $kegiatan_id)->first()->bidang_id;
        }
    }

    public function view(): View
    {
        $tahun = $this->request->tahun;
        $bulan = $this->request->bulan;
        $requestBidang = $this->request->requestBidang;

        $bidang_id = null;
        $role = Auth::user()->getRoleNames();
        $idBidangKontraktor = $this->getIdBidangKontraktor($role);
        $kegiatan_id = Kegiatan::pluck('id');
        if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang")) {
            $bidang_id = Auth::user()->bidang_id;
            $kegiatan_id = Kegiatan::where('bidang_id', $bidang_id)->pluck('id');
        }
        if ($role[0] == 'Kontraktor') {
            $bidang_id = Kegiatan::where('id', $idBidangKontraktor)->first()->bidang_id;
        }
        if ($requestBidang) {
            $bidang_id = $requestBidang;
        }

        $bidang = Bidang::with('kegiatan.detail.progres')->where('id', $bidang_id)->get();
        if ($bidang_id == null) {
            $bidang = Bidang::with('kegiatan.detail.progres')->get();
        }
        $bidang->map(function ($bidang) {
            $bidang->kegiatan->map(function ($kegiatan) {
                $total_keuangan_kegiatan = 0;
                $kegiatan->detail->map(function ($detail) use ($kegiatan, &$total_keuangan_kegiatan) {
                    $detail->total_keuangan = $detail->progres->where('jenis_progres', 'keuangan')->sum('nilai');
                    $detail->total_fisik = $detail->progres->where('jenis_progres', 'fisik')->sum('nilai');
                    $total_keuangan_kegiatan += $detail->total_keuangan;
                });
                $kegiatan->sisa = $kegiatan->alokasi - $total_keuangan_kegiatan;
            });
        });
        return view('backend.exports.laporan', compact(['tahun', 'bulan', 'bidang', 'bidang_id']));
    }
}
