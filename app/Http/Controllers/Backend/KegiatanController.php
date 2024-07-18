<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\DetailKegiatan;
use App\Models\Bidang;
use App\Models\Program;
use App\Models\Anggaran;
use App\Models\PenyediaJasa;
use App\Models\PenanggungJawab;
use App\Models\Pengambilan;
use App\Models\SumberDana;
use App\Exports\LaporanPengambilanExport;
use App\Models\SubKegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class KegiatanController extends Controller
{
    public $bidang_id;
    public $request;
    public $kontraktorId;
    public $bidangId;
    public $kegiatan_id;
    public function index(Request $request)
    {
        $this->request = $request;
        $this->bidang_id =  Auth::user()->bidang_id;
        $role = Auth::user()->getRoleNames();
        $idKontraktor = PenyediaJasa::where('email', Auth::user()->email)->pluck('id');
        if ($role[0] == "Kontraktor") {
            $detailKontraktor = DetailKegiatan::where('penyedia_jasa_id', $idKontraktor)->pluck('kegiatan_id');
            $this->bidangId = Kegiatan::whereIn('id', $detailKontraktor)->pluck('bidang_id');
            $this->kegiatan_id = Kegiatan::whereIn('id', $detailKontraktor)->pluck('id');
            $this->kontraktorId = $idKontraktor;
        }

        if ($role[0] == 'Pengawas') {
            $idPengawas = PenanggungJawab::where('pptk_email', Auth::user()->email)->first()->pluck('id');
            $kegiatanIds = DetailKegiatan::whereIn('penanggung_jawab_id', $idPengawas)->pluck('kegiatan_id');
            // dd($idPengawas, $kegiatanIds);
            $this->bidangId = Kegiatan::whereIn('id', $kegiatanIds)->pluck('bidang_id');
            $this->kegiatan_id = Kegiatan::whereIn('id', $kegiatanIds)->pluck('id');
        }
        // dd($idPengawas, $kegiatanIds, $this->bidangId, $this->kegiatan_id);
        if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang") || str_contains($role[0], "Kontraktor") || str_contains($role[0], "Konsultan")) {
            $bidang = Bidang::where('id', $this->bidang_id)->orderBy('created_at', 'desc')->get();
            if ($role[0] == "Kontraktor") {
                if ($this->bidang_id == null) {
                    $bidang = Bidang::whereIn('id', $this->bidangId)->orderBy('created_at', 'desc')->get();
                }
            }
            $kegiatanProgram = Kegiatan::where('bidang_id', $this->bidang_id)->pluck('program')->first();
            $program = Program::where('id', $kegiatanProgram)->get();
        } else if ($role[0] == "Pengawas") {
            if ($this->bidang_id == null) {
                $bidang = Bidang::whereIn('id', $this->bidangId)->orderBy('created_at', 'desc')->get();
            }
            $kegiatanProgram = Kegiatan::where('bidang_id', $this->bidang_id)->pluck('program')->first();
            $program = Program::where('id', $kegiatanProgram)->get();
        } else {
            $bidang = Bidang::orderBy('created_at', 'desc')->get();
            $program = Program::orderBy('created_at', 'desc')->get();
        }
        $bidang->map(function ($item) {
            if ($this->request['tahun'] != null) {
                $kegiatan = Kegiatan::where('bidang_id', $item->id)->where('is_arship', 0)->where('tahun', $this->request['tahun'])->orderBy('created_at', 'desc')->get();
            } else {
                $kegiatan = Kegiatan::where('bidang_id', $item->id)->where('is_arship', 0)->orderBy('created_at', 'desc')->get();
            }
            if (Auth::user()->getRoleNames()[0] == "Kontraktor") {
                $kegiatan = Kegiatan::where('bidang_id', $item->id)->where('is_arship', 0)->whereIn('id', $this->kegiatan_id)->orderBy('created_at', 'desc')->get();
            }
            $kegiatan->map(function ($query) {
                $penanggung = PenanggungJawab::where('kegiatan_id', $query->id)->first();
                $detailKegiatan = DetailKegiatan::where('kegiatan_id', $query->id)->orderBy('created_at', 'desc')->get();
                if (Auth::user()->getRoleNames()[0] == "Kontraktor") {
                    $detailKegiatan = DetailKegiatan::where('penyedia_jasa_id', $this->kontraktorId)->orderBy('created_at', 'desc')->get();
                }
                $detailKegiatan->map(function ($detail) {
                    $anggaran = Anggaran::where('detail_kegiatan_id', $detail->id)->orderBy('created_at', 'desc')->get();
                    $detail->anggaran = $anggaran;
                    $detail->total_realisasi = $anggaran->sum('daya_serap_kontrak');
                });
                $query->penanggung = $penanggung;
                $query->detail_kegiatan = $detailKegiatan;
                $query->total_pagu = $detailKegiatan->sum(function ($detail) {
                    return (int) $detail->pagu;
                });
                $query->total_realisasi = $detailKegiatan->sum('total_realisasi');
                $query->total_sisa = $query->alokasi - $detailKegiatan->sum('total_realisasi');
            });
            $item->kegiatan = $kegiatan;
            $item->total_pagu = $kegiatan->sum('total_pagu');
        });

        $program->map(function ($item) {
            if ($this->request['tahun'] != null) {
                $kegiatan = Kegiatan::where('program', $item->id)->where('is_arship', 0)->where('tahun', $this->request['tahun'])->orderBy('created_at', 'desc')->get();
            } else {
                $kegiatan = Kegiatan::where('program', $item->id)->where('is_arship', 0)->orderBy('created_at', 'desc')->get();
            }
            $kegiatan->map(function ($query) {
                $penanggung = PenanggungJawab::where('kegiatan_id', $query->id)->first();
                $detailKegiatan = DetailKegiatan::where('kegiatan_id', $query->id)->orderBy('created_at', 'desc')->get();
                $detailKegiatan->map(function ($detail) {
                    $anggaran = Anggaran::where('detail_kegiatan_id', $detail->id)->orderBy('created_at', 'desc')->get();
                    $detail->anggaran = $anggaran;
                    $detail->total_realisasi = $anggaran->sum('daya_serap_kontrak');
                });
                $query->penanggung = $penanggung;
                $query->detail_kegiatan = $detailKegiatan;
                $query->total_pagu = $detailKegiatan->sum(function ($detail) {
                    return (int) $detail->pagu;
                });
                $query->total_realisasi = $detailKegiatan->sum('total_realisasi');
                $query->total_sisa = $query->alokasi - $detailKegiatan->sum('total_realisasi');
            });
            $item->kegiatan = $kegiatan;
            $item->total_pagu = $kegiatan->sum('total_pagu');
        });
        $penyedia_jasa = PenyediaJasa::orderBy('created_at', 'desc')->get();
        $sumber_dana = SumberDana::orderBy('created_at', 'desc')->get();
        return view('backend.kegiatan.index', compact(['bidang', 'program', 'penyedia_jasa', 'sumber_dana']));
    }


    public function getKegiatan(Request $request)
    {
        $kegiatan = Kegiatan::where('bidang_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->get();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $kegiatan
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $kegiatan = Kegiatan::create([
            'title' => $request->title,
            'no_rek' => $request->no_rek,
            'alokasi' => 0,
            'tahun' => $request->tahun,
            'program' => $request->program,
            'no_rek_program' => '-',
            'bidang_id' => $request->bidang_id,
            'sumber_dana' => 1,
            'jenis_paket' => 1,
        ]);
        return redirect()->route('backend.sub_kegiatan.index')->with('success', 'Kegiatan berhasil disimpan')->with('tab', 'kegiatan');
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::where('id', $id)->update([
            'title' => $request->title,
            'no_rek' => $request->no_rek,
            'alokasi' => $request->alokasi,
            'tahun' => $request->tahun,
            'program' => $request->program,
            'no_rek_program' => $request->no_rek_program,
            'bidang_id' => $request->bidang_id,
            'sumber_dana' => $request->sumber_dana,
            'jenis_paket' => $request->jenis_paket,
        ]);
        return redirect()->route('backend.kegiatan.index')->with('success', 'Kegiatan berhasil diedit');
    }

    public function arship(Request $request, $id)
    {
        $kegiatan = Kegiatan::where('id', $id)->update([
            'is_arship' => 1,
        ]);
        return redirect()->route('backend.kegiatan.index')->with('success', 'Kegiatan berhasil diarsipkan');
    }


    public function deleteMasterKegiatan($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $kegiatan->delete();
        return redirect()->route('backend.sub_kegiatan.index')->with('success', 'Kegiatan berhasil dihapus')->with('tab', 'kegiatan');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $kegiatan->delete();
        return redirect()->route('backend.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }
    public function search(Request $request)
    {
        $bidang = Bidang::orderBy('created_at', 'desc')
            ->get();
        $program = Program::orderBy('created_at', 'desc')
            ->get();
        $detailKegiatan = DetailKegiatan::filter($request)->orderBy('created_at', 'desc')->get();
        $sumber_dana = SumberDana::orderBy('created_at', 'desc')->get();
        return view('backend.kegiatan.pencarian', compact(['detailKegiatan', 'program', 'bidang', 'sumber_dana']));
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
    public function laporan(Request $request)
    {
        $listBidang = Bidang::all();
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $requestBidang = $request->bidang;
        $search = $request->search;

        $bidang_id = null;
        $role = Auth::user()->getRoleNames();
        $idBidangKontraktor = $this->getIdBidangKontraktor($role);
        $kegiatan_id = Kegiatan::pluck('id');
        $penyedia_jasa = PenyediaJasa::where('email', Auth::user()->email)->first();
        if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang") || str_contains($role[0], "Kontraktor")) {
            $bidang_id = Auth::user()->bidang_id;
            $kegiatan_id = Kegiatan::where('bidang_id', $bidang_id)->pluck('id');
            if ($role[0] == 'Kontraktor') {
                $bidang_id = Kegiatan::where('id', $idBidangKontraktor)->first()->bidang_id;
            }
        }
        if ($requestBidang) {
            $bidang_id = $requestBidang;
        }
        if ($search) {
            $bidang = Bidang::with(['kegiatan' => function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->with('detail.progres');
            }])->where('id', $bidang_id)->get();
        } else {
            $bidang = Bidang::with('kegiatan.detail.progres')->where('id', $bidang_id)->get();
        }
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
                    $detail->progres->map(function ($progres) use ($detail) {
                        $detail->progress = $progres->orderBy('nilai', 'desc')->first()->nilai;
                    });
                });
                $kegiatan->sisa = $kegiatan->alokasi - $total_keuangan_kegiatan;
            });
        });

        $kegiatan = Kegiatan::whereIn('id', $kegiatan_id->toArray())->get();
        $details = $role[0] == 'Kontraktor' ? DetailKegiatan::with('progres')->where('penyedia_jasa_id', $penyedia_jasa->id)->get() : DetailKegiatan::with('progres')->whereIn('kegiatan_id', $kegiatan_id->toArray())->get();
        return view('backend.kegiatan.laporan', compact(['listBidang', 'tahun', 'bulan', 'bidang', 'requestBidang', 'search']));
    }

    public function laporanDPA(Request $request)
    {
        $bidang_id = null;
        $role = Auth::user()->getRoleNames();
        if (str_contains($role[0], "Staff")) {
            $bidang_id = Auth::user()->bidang_id;
        }
        $dpa = Dpa::filter($request)->get();
        foreach ($dpa as $key => $item) {
            $details = DetailKegiatan::select(
                'detail_kegiatan.title as sub_kegiatan_title',
                'detail_kegiatan.id',
                'detail_kegiatan.pagu',
                'kegiatan.title as kegiatan_title',
                'kegiatan.alokasi as alokasi',
                'program.name as program_title'
            )->filter($request)
                ->leftJoin('kegiatan', function ($join) {
                    $join->on('detail_kegiatan.kegiatan_id', '=', 'kegiatan.id');
                })
                ->leftJoin('program', function ($join) {
                    $join->on('kegiatan.program', '=', 'program.id');
                })
                ->whereHas('kegiatan', function ($query) use ($bidang_id) {
                    $query->where('is_arship', 0);
                    if ($bidang_id) {
                        $query->where('bidang_id', $bidang_id);
                    }
                })->get();
            foreach ($details as $key => $detail) {
                $totalbelanjaOperasi = Pagu::where('dpa_id', '=', $item->id)->sum('belanja_operasi');
                $totalbelanjaModal = Pagu::where('dpa_id', '=', $item->id)->sum('belanja_modal');
                $totalbelanjaTakTerduga = Pagu::where('dpa_id', '=', $item->id)->sum('belanja_tak_terduga');
                $totalbelanjaTransfer = Pagu::where('dpa_id', '=', $item->id)->sum('belanja_transfer');
                $totalOperasi = Pengambilan::where('dpa_id', '=', $item->id)->sum('belanja_operasi');
                $totalModal = Pengambilan::where('dpa_id', '=', $item->id)->sum('belanja_modal');
                $totalTakTerduga = Pengambilan::where('dpa_id', '=', $item->id)->sum('belanja_tak_terduga');
                $totalTransfer = Pengambilan::where('dpa_id', '=', $item->id)->sum('belanja_transfer');
                $detail->anggaran_belanja_operasi = $totalbelanjaOperasi;
                $detail->anggaran_belanja_modal = $totalbelanjaModal;
                $detail->anggaran_belanja_tak_terduga = $totalbelanjaTakTerduga;
                $detail->anggaran_belanja_transfer = $totalbelanjaTransfer;
                $detail->pengambilan_belanja_operasi = $totalOperasi;
                $detail->pengambilan_belanja_modal = $totalModal;
                $detail->pengambilan_belanja_tak_terduga = $totalTakTerduga;
                $detail->pengambilan_belanja_transfer = $totalTransfer;
            }
        }

        $tahun = $request->tahun;
        $bulan = $request->bulan;
        // $bidang = Bidang::orderBy('created_at', 'desc')
        // ->get();
        // $program = Program::orderBy('created_at', 'desc')
        // ->get();
        // $detailKegiatan = DetailKegiatan::filter($request)->orderBy('created_at', 'desc')->get();
        return view('backend.kegiatan.laporan', compact(['details', 'tahun', 'bulan']));
    }

    public function updatePptk(Request $request, $detail_kegiatan_id)
    {
        $updatePJ = PenanggungJawab::updateOrCreate(
            ['detail_kegiatan_id' => $detail_kegiatan_id],
            [
                'pptk_name' => $request->pptk_name,
                'pptk_nip' => $request->pptk_nip,
                'pptk_email' => $request->pptk_email,
                'pptk_telpon' => $request->pptk_telpon,
                'pptk_bidang_id' => $request->pptk_bidang_id,
                'ppk_name' => $request->ppk_name,
                'ppk_nip' => $request->ppk_nip,
                'ppk_email' => $request->ppk_email,
                'ppk_telpon' => $request->ppk_telpon,
                'ppk_bidang_id' => $request->ppk_bidang_id,
                'detail_kegiatan_id' => $detail_kegiatan_id,
            ]
        );
        if ($updatePJ) {
            $detail = DetailKegiatan::where('id', $detail_kegiatan_id)->first();
            $detail->update(
                ['penanggung_jawab_id' => $updatePJ->id],
            );
        }

        return redirect()->route('backend.detail_anggaran.index', $detail_kegiatan_id)->with('success', 'PPTK/Pimpinan teknis berhasil diubah');
    }

    public function downloadLaporan(Request $request)
    {
        return Excel::download(new LaporanPengambilanExport($request), 'laporan_kegiatan.xlsx');
    }
}
