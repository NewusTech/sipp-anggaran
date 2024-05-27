<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dpa;
use App\Models\Anggaran;
use App\Models\Pengambilan;
use App\Models\Urusan;
use App\Models\Bidang;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\DetailKegiatan;
use App\Models\Organisasi;
use App\Models\Unit;
use App\Models\Pagu;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use App\Models\PenggunaAnggaran;
use App\Models\TandaTangan;
use Illuminate\Support\Facades\Validator;

class DpaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dpa = Dpa::select('dpa.*', 'urusan.name as urusan')
            ->leftJoin('urusan', function ($join) {
                $join->on('dpa.urusan_id', '=', 'urusan.id');
            })
            ->orderBy('dpa.created_at', 'desc')->get();
        $urusan = Urusan::select('id', 'name')->get();
        $bidang = Bidang::select('id', 'name')->get();
        $program = Program::select('id', 'name')->get();
        $kegiatan = Kegiatan::select('id', 'title')->get();
        $organisasi = Organisasi::select('id', 'name')->get();
        $unit = Unit::all();
        return view('backend.dpa.index', compact(['dpa', 'program', 'urusan', 'bidang', 'organisasi', 'unit', 'kegiatan']));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByProgram()
    {
        $program = Dpa::select('program.name', 'program.kode', 'dpa.id as dpa_id', 'dpa.program_id')
            ->leftJoin('program', function ($join) {
                $join->on('dpa.program_id', '=', 'program.id');
            })
            ->groupBy('dpa.program_id')
            ->orderBy('dpa.created_at', 'desc')->get();

        return view('backend.dpa.program', compact(['program']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByKegiatan($program_id)
    {
        $kegiatan = Dpa::select('kegiatan.title', 'kegiatan.no_rek', 'kegiatan.id', 'dpa.kegiatan_id', 'kegiatan.program')
            ->leftJoin('kegiatan', function ($join) {
                $join->on('dpa.kegiatan_id', '=', 'kegiatan.id');
            })
            ->groupBy('dpa.kegiatan_id')
            ->orderBy('dpa.created_at', 'desc')->get();
        return view('backend.dpa.kegiatan', compact(['kegiatan']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByDetailKegiatan($program_id, $kegiatan_id)
    {
        $detail = SubKegiatan::select('detail_kegiatan.title', 'detail_kegiatan.no_kontrak', 'detail_kegiatan.id')
            ->leftJoin('detail_kegiatan', function ($join) {
                $join->on('sub_kegiatan.detail_kegiatan_id', '=', 'detail_kegiatan.id');
            })
            ->where('sub_kegiatan.kegiatan_id', $kegiatan_id)
            ->orderBy('sub_kegiatan.created_at', 'desc')->get();

        return view('backend.dpa.detail_kegiatan', compact(['detail', 'program_id']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByPengambilan($detail_kegiatan_id)
    {
        $detail = DetailKegiatan::with('penyedia')->where('id', $detail_kegiatan_id)->first();
        $kegiatan = Kegiatan::where('id', $detail->kegiatan_id)->orderBy('created_at', 'desc')->first();
        $program = Program::where('id', $kegiatan->program)->first();
        $kegiatan->program = $program->name;
        $totalbelanjaOperasi = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Operasi')->sum('daya_serap_kontrak');
        $totalbelanjaModal = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Modal')->sum('daya_serap_kontrak');
        $totalbelanjaTakTerduga = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Tak Terduga')->sum('daya_serap_kontrak');
        $totalbelanjaTransfer = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap', 'Belanja Transfer')->sum('daya_serap_kontrak');
        $totalOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_operasi');
        $totalModal = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_modal');
        $totalTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_tak_terduga');
        $totalTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_transfer');
        $pengambilan = Pengambilan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        return view(
            'backend.dpa.pengambilan',
            compact(
                'detail',
                'kegiatan',
                'program',
                'totalbelanjaOperasi',
                'totalbelanjaModal',
                'totalbelanjaTakTerduga',
                'totalbelanjaTransfer',
                'totalOperasi',
                'totalModal',
                'totalTakTerduga',
                'totalTransfer',
                'pengambilan'
            )
        );
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
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_dpa' => 'required',
            'tahun' => 'required',
            'alokasi' => 'required',
            'urusan_id' => 'required',
            'bidang_id' => 'required',
            'kegiatan_id' => 'required',
            'program_id' => 'required',
            'organisasi_id' => 'required',
            'unit_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('backend.dpa.index')
                ->withErrors($validator)
                ->withInput();
        }

        $dpa = Dpa::create([
            'no_dpa' => $request->no_dpa,
            'tahun' => $request->tahun,
            'alokasi' => $request->alokasi,
            'urusan_id' => $request->urusan_id,
            'bidang_id' => $request->bidang_id,
            'kegiatan_id' => $request->kegiatan_id,
            'program_id' => $request->program_id,
            'organisasi_id' => $request->organisasi_id,
            'unit_id' => $request->unit_id,
        ]);
        return redirect()->route('backend.dpa.index')->with('success', 'DPA berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dpa = Dpa::select(
            'dpa.no_dpa',
            'dpa.tahun',
            'dpa.alokasi',
            'dpa.kegiatan_id',
            'dpa.id',
            'dpa.realisasi',
            'urusan.name as urusan',
            'urusan.kode as kode_urusan',
            'bidang.name as bidang',
            'bidang.kode as kode_bidang',
            'program.name as program',
            'program.kode as kode_program',
            'kegiatan.title as kegiatan',
            'kegiatan.no_rek_program as no_kegiatan',
            'organisasi.name as organisasi',
            'organisasi.kode as kode_organisasi',
            'unit.name as unit',
            'unit.kode as kode_unit'
        )->where('dpa.id', $id)
            ->leftJoin('urusan', function ($join) {
                $join->on('dpa.urusan_id', '=', 'urusan.id');
            })
            ->leftJoin('bidang', function ($join) {
                $join->on('dpa.bidang_id', '=', 'bidang.id');
            })
            ->leftJoin('program', function ($join) {
                $join->on('dpa.program_id', '=', 'program.id');
            })
            ->leftJoin('kegiatan', function ($join) {
                $join->on('dpa.kegiatan_id', '=', 'kegiatan.id');
            })
            ->leftJoin('organisasi', function ($join) {
                $join->on('dpa.organisasi_id', '=', 'organisasi.id');
            })
            ->leftJoin('unit', function ($join) {
                $join->on('dpa.unit_id', '=', 'unit.id');
            })->first();

        $sub_kegiatan = SubKegiatan::select(
            'sub_kegiatan.*',
            'sumber_dana.name as sumber_dana',
            'detail_kegiatan.no_kontrak as no_kontrak',
            'detail_kegiatan.title as detail_kegiatan',
            'detail_kegiatan.no_detail_kegiatan as no_detail_kegiatan',
            'detail_kegiatan.alamat as lokasi'
        )->leftJoin('sumber_dana', function ($join) {
            $join->on('sub_kegiatan.sumber_dana_id', '=', 'sumber_dana.id');
        })
            ->leftJoin('detail_kegiatan', function ($join) {
                $join->on('sub_kegiatan.detail_kegiatan_id', '=', 'detail_kegiatan.id');
            })
            ->where('sub_kegiatan.dpa_id', '=', $id)->where('sumber_dana.deleted_at', null)->get();

        $sub_kegiatan->map(function ($sub) {
            $pagu = Pagu::where('sub_kegiatan_id', $sub->id)->first();
            $sub->pagu = $pagu;
        });
        $sumber_dana = SumberDana::orderBy('created_at', 'desc')->get();
        $details = DetailKegiatan::where('kegiatan_id', $dpa->kegiatan_id)->orderBy('created_at', 'desc')->get();
        $pengguna = PenggunaAnggaran::where('dpa_id', $id)->orderBy('created_at', 'desc')->get();
        $ttd = TandaTangan::where('dpa_id', $id)->orderBy('created_at', 'desc')->get();
        $totalbelanjaOperasi = Pagu::where('dpa_id', '=', $id)->sum('belanja_operasi');
        $totalbelanjaModal = Pagu::where('dpa_id', '=', $id)->sum('belanja_modal');
        $totalbelanjaTakTerduga = Pagu::where('dpa_id', '=', $id)->sum('belanja_tak_terduga');
        $totalbelanjaTransfer = Pagu::where('dpa_id', '=', $id)->sum('belanja_transfer');
        $totalOperasi = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_operasi');
        $totalModal = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_modal');
        $totalTakTerduga = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_tak_terduga');
        $totalTransfer = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_transfer');
        $pengambilan = Pengambilan::where('dpa_id', $id)->get();
        return view('backend.dpa.show', compact([
            'dpa',
            'sub_kegiatan',
            'sumber_dana',
            'details',
            'pengguna',
            'ttd',
            'totalbelanjaOperasi',
            'totalbelanjaModal',
            'totalbelanjaTakTerduga',
            'totalbelanjaTransfer',
            'totalOperasi',
            'totalModal',
            'totalTakTerduga',
            'totalTransfer',
            'pengambilan'
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result($id)
    {
        $dpa = Dpa::select(
            'dpa.no_dpa',
            'dpa.tahun',
            'dpa.alokasi',
            'dpa.kegiatan_id',
            'dpa.id',
            'dpa.realisasi',
            'urusan.name as urusan',
            'urusan.kode as kode_urusan',
            'bidang.name as bidang',
            'bidang.kode as kode_bidang',
            'program.name as program',
            'program.kode as kode_program',
            'kegiatan.title as kegiatan',
            'kegiatan.no_rek as no_kegiatan',
            'organisasi.name as organisasi',
            'organisasi.kode as kode_organisasi',
            'unit.name as unit',
            'unit.kode as kode_unit'
        )->where('dpa.id', $id)
            ->leftJoin('urusan', function ($join) {
                $join->on('dpa.urusan_id', '=', 'urusan.id');
            })
            ->leftJoin('bidang', function ($join) {
                $join->on('dpa.bidang_id', '=', 'bidang.id');
            })
            ->leftJoin('program', function ($join) {
                $join->on('dpa.program_id', '=', 'program.id');
            })
            ->leftJoin('kegiatan', function ($join) {
                $join->on('dpa.kegiatan_id', '=', 'kegiatan.id');
            })
            ->leftJoin('organisasi', function ($join) {
                $join->on('dpa.organisasi_id', '=', 'organisasi.id');
            })
            ->leftJoin('unit', function ($join) {
                $join->on('dpa.unit_id', '=', 'unit.id');
            })->first();

        $sub_kegiatan = SubKegiatan::select(
            'sub_kegiatan.*',
            'sumber_dana.name as sumber_dana',
            'detail_kegiatan.no_kontrak as no_kontrak',
            'detail_kegiatan.title as detail_kegiatan',
            'detail_kegiatan.alamat as lokasi'
        )->leftJoin('sumber_dana', function ($join) {
            $join->on('sub_kegiatan.sumber_dana_id', '=', 'sumber_dana.id');
        })
            ->leftJoin('detail_kegiatan', function ($join) {
                $join->on('sub_kegiatan.detail_kegiatan_id', '=', 'detail_kegiatan.id');
            })
            ->where('sub_kegiatan.dpa_id', '=', $id)->where('sumber_dana.deleted_at', null)->get();

        $sub_kegiatan->map(function ($sub) {
            $pagu = Pagu::where('sub_kegiatan_id', $sub->id)->first();
            $sub->pagu = $pagu;
        });
        $sumber_dana = SumberDana::orderBy('created_at', 'desc')->get();
        $details = DetailKegiatan::where('kegiatan_id', $dpa->kegiatan_id)->orderBy('created_at', 'desc')->get();
        $pengguna = PenggunaAnggaran::where('dpa_id', $id)->orderBy('created_at', 'desc')->get();
        $ttd = TandaTangan::where('dpa_id', $id)->orderBy('created_at', 'desc')->get();
        $totalbelanjaOperasi = Pagu::where('dpa_id', '=', $id)->sum('belanja_operasi');
        $totalbelanjaModal = Pagu::where('dpa_id', '=', $id)->sum('belanja_modal');
        $totalbelanjaTakTerduga = Pagu::where('dpa_id', '=', $id)->sum('belanja_tak_terduga');
        $totalbelanjaTransfer = Pagu::where('dpa_id', '=', $id)->sum('belanja_transfer');
        $totalOperasi = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_operasi');
        $totalModal = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_modal');
        $totalTakTerduga = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_tak_terduga');
        $totalTransfer = Pengambilan::where('dpa_id', '=', $id)->sum('belanja_transfer');
        $pengambilan = Pengambilan::where('dpa_id', $id)->get();
        return view('backend.dpa.result', compact([
            'dpa',
            'sub_kegiatan',
            'sumber_dana',
            'details',
            'pengguna',
            'ttd',
            'totalbelanjaOperasi',
            'totalbelanjaModal',
            'totalbelanjaTakTerduga',
            'totalbelanjaTransfer',
            'totalOperasi',
            'totalModal',
            'totalTakTerduga',
            'totalTransfer',
            'pengambilan'
        ]));
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
        $dpa = Dpa::where('id', '=', $id)->update([
            'no_dpa' => $request->no_dpa,
            'alokasi' => $request->alokasi,
            'urusan_id' => $request->urusan_id,
            'bidang_id' => $request->bidang_id,
            'kegiatan_id' => $request->kegiatan_id,
            'program_id' => $request->program_id,
            'organisasi_id' => $request->organisasi_id,
            'unit_id' => $request->unit_id,
        ]);
        return redirect()->route('backend.dpa.index')->with('success', 'DPA berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dpa = Dpa::where('id', $id)->first();
        $dpa->delete();
        return redirect()->route('backend.dpa.index')->with('success', 'DPA berhasil dihapus');
    }
}
