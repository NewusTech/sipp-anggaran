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
use App\Models\Dpa;
use App\Models\Pagu;
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
        $this->bidang_id =  $this->getLoggedUser()->bidang_id;
        $role = $this->getLoggedUser()->getRoleNames();
        $kegiatans = Kegiatan::get(['id', 'title']);
        $subKegiatans = SubKegiatan::get(['id', 'title']);

        $bidang = $this->bidang_id != null ? Bidang::where('id', $this->bidang_id)->orderBy('created_at', 'desc')->get() : Bidang::orderBy('created_at', 'desc')->get();

        if ($role[0] == 'Pengawas') {
            $idPengawas = PenanggungJawab::where('pptk_email', $this->getLoggedUser()->email)->first('id');
            $bidang = Bidang::with('kegiatan.subKegiatan.detail')->get();

            $bidang = $bidang->map(function ($bidang) use ($idPengawas) {
                $bidang->kegiatan = $bidang->kegiatan->map(function ($kegiatan) use ($idPengawas) {
                    $kegiatan->subKegiatan = $kegiatan->subKegiatan->map(function ($subKegiatan) use ($idPengawas) {
                        $subKegiatan->detail = $subKegiatan->detail->filter(function ($detail) use ($idPengawas) {
                            return $detail->penanggung_jawab_id == $idPengawas->id;
                        });
                        return $subKegiatan;
                    });
                    return $kegiatan;
                });
                return $bidang;
            });
        }

        $bidang->map(fn ($bidang) => $bidang->totalPagu = $this->getTotalPaguBidang($bidang->id));
        $program = Program::get(['id', 'name']);
        $penyedia_jasa = PenyediaJasa::orderBy('created_at', 'desc')->get();
        $sumber_dana = SumberDana::orderBy('created_at', 'desc')->get();
        return view('backend.kegiatan.index', compact(['bidang', 'program', 'penyedia_jasa', 'sumber_dana', 'kegiatans', 'subKegiatans']));
    }

    public function getTotalPaguBidang($bidang_id)
    {
        if ($bidang_id) {
            $kegiatans = Kegiatan::where('bidang_id', $bidang_id)->get();
            $totalPagu = $kegiatans->map(function ($kegiatan) {
                return $kegiatan->detail->sum('pagu');
            });
            return $totalPagu->sum();
        } elseif ($bidang_id == null) {
            $kegiatans = Kegiatan::get();
            $totalPagu = $kegiatans->map(function ($kegiatan) {
                return $kegiatan->detail->sum('pagu');
            });
            return $totalPagu->sum();
        }
    }
    public function getLoggedUser()
    {
        return Auth::user();
    }


    public function getKegiatanByProgram(Request $request)
    {
        $kegiatans = Kegiatan::where('program', $request->id)
            ->orderBy('created_at', 'desc')
            ->get();
        //return response
        return response()->json($kegiatans);
    }

    public function store(Request $request): RedirectResponse
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
        try {
            $kegiatan = Kegiatan::find($id);
            $kegiatan->fill($request->all());
            if ($kegiatan->isDirty()) {
                $kegiatan->save();
            }
            return redirect()->route('backend.kegiatan.index')->with('success', 'Kegiatan berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->route('backend.kegiatan.index')->with('error', 'Kegiatan gagal diedit');
        }
    }

    public function arship(Request $request, $id)
    {
        // dd($request->all());
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
