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
use Maatwebsite\Excel\Facades\Excel;

class KegiatanController extends Controller
{
    public $bidang_id;
    public $request;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->request = $request;
        $this->bidang_id =  Auth::user()->bidang_id;
        $role = Auth::user()->getRoleNames();
        if (str_contains($role[0], "Staff") || str_contains($role[0], "Kepala Bidang")) {
            $bidang = Bidang::where('id', $this->bidang_id)->orderBy('created_at', 'desc')->get();

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
                $query->total_pagu = $detailKegiatan->sum('pagu');
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
                $query->total_pagu = $detailKegiatan->sum('pagu');
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request)
    {
        $kegiatan = Kegiatan::create([
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
        return redirect()->route('backend.kegiatan.index')->with('success', 'Kegiatan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    public function laporan(Request $request)
    {
        $bidang_id = null;
        $role = Auth::user()->getRoleNames();
        if (str_contains($role[0], "Staff")) {
            $bidang_id = Auth::user()->bidang_id;
        }
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
            $totalbelanjaOperasi = Anggaran::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Operasi')->sum('daya_serap_kontrak');
            $totalbelanjaModal = Anggaran::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Modal')->sum('daya_serap_kontrak');
            $totalbelanjaTakTerduga = Anggaran::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Tak Terduga')->sum('daya_serap_kontrak');
            $totalbelanjaTransfer = Anggaran::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Transfer')->sum('daya_serap_kontrak');
            $totalOperasi = Pengambilan::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_operasi');
            $totalModal = Pengambilan::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_modal');
            $totalTakTerduga = Pengambilan::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_tak_terduga');
            $totalTransfer = Pengambilan::filter($request)->where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_transfer');
            $detail->anggaran_belanja_operasi = $totalbelanjaOperasi;
            $detail->anggaran_belanja_modal = $totalbelanjaModal;
            $detail->anggaran_belanja_tak_terduga = $totalbelanjaTakTerduga;
            $detail->anggaran_belanja_transfer = $totalbelanjaTransfer;
            $detail->pengambilan_belanja_operasi = $totalOperasi;
            $detail->pengambilan_belanja_modal = $totalModal;
            $detail->pengambilan_belanja_tak_terduga = $totalTakTerduga;
            $detail->pengambilan_belanja_transfer = $totalTransfer;
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

    public function updatePptk(Request $request, $kegiatan_id)
    {
        $kegiatan = PenanggungJawab::updateOrCreate([
            'kegiatan_id' => $kegiatan_id,
        ], [
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
            'kegiatan_id' => $kegiatan_id
        ]);
        return redirect()->route('backend.kegiatan.index')->with('success', 'PPTK/Pimpinan teknis berhasil diubah');
    }

    public function downloadLaporan(Request $request)
    {
        return Excel::download(new LaporanPengambilanExport($request), 'laporan_pengambilan.xlsx');
    }
}
