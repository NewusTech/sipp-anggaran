<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Anggaran\StoreAnggaranRequest;
use App\Http\Requests\Backend\Anggaran\UpdateAnggaranRequest;
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

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index($detail_kegiatan_id): View|Factory|Application
    {
        $detail = DetailKegiatan::with('penyedia')->where('id', $detail_kegiatan_id)->first();
        $anggaran = Anggaran::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $dokumentasi = Dokumentasi::where('detail_kegiatan_id', $detail_kegiatan_id)->with('files')->get();
        $isEdit = false;
        $kegiatan = Kegiatan::where('id', $detail->kegiatan_id)->orderBy('created_at', 'desc')->first();
				$penanggung = PenanggungJawab::where('kegiatan_id', $kegiatan->id)->first();
				$program = Program::where('id', $kegiatan->program)->first();
				$kegiatan->penanggung = $penanggung;
				$kegiatan->program = $program->name;
        $totalbelanjaOperasi = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Operasi')->sum('daya_serap_kontrak');
				$totalbelanjaModal = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Modal')->sum('daya_serap_kontrak');
				$totalbelanjaTakTerduga = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Tak Terduga')->sum('daya_serap_kontrak');
				$totalbelanjaTransfer = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Transfer')->sum('daya_serap_kontrak');
        $totalOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_operasi');
				$totalModal = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_modal');
				$totalTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_tak_terduga');
				$totalTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_transfer');
        $pengambilan = Pengambilan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        return view('backend.kegiatan.detail_anggaran', 
        compact(
          'detail', 
          'anggaran', 
          'dokumentasi', 
          'isEdit',
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
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param $detail_kegiatan_id
     * @return Application|Factory|View
     */
    public function show($detail_kegiatan_id): View|Factory|Application
    {
        $detail = DetailKegiatan::with('penyedia')->where('id', $detail_kegiatan_id)->first();
        $anggaran = Anggaran::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $dokumentasi = Dokumentasi::where('detail_kegiatan_id', $detail_kegiatan_id)->with('files')->get();
        $isEdit = true;
				$kegiatan = Kegiatan::where('id', $detail->kegiatan_id)->orderBy('created_at', 'desc')->first();
				$penanggung = PenanggungJawab::where('kegiatan_id', $kegiatan->id)->first();
				$program = Program::where('id', $kegiatan->program)->first();
				$kegiatan->penanggung = $penanggung;
				$kegiatan->program = $program->name;
        $totalbelanjaOperasi = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Operasi')->sum('daya_serap_kontrak');
				$totalbelanjaModal = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Modal')->sum('daya_serap_kontrak');
				$totalbelanjaTakTerduga = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Tak Terduga')->sum('daya_serap_kontrak');
				$totalbelanjaTransfer = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Transfer')->sum('daya_serap_kontrak');
        $totalOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_operasi');
				$totalModal = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_modal');
				$totalTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_tak_terduga');
				$totalTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_transfer');
        $pengambilan = Pengambilan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        return view('backend.kegiatan.edit_anggaran', 
        compact(
          'detail', 
          'anggaran', 
          'dokumentasi', 
          'isEdit',
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
        ));
    }

    public function edit($detail_kegiatan_id): View|Factory|Application
    {
        $detail = DetailKegiatan::with('penyedia')->where('id', $detail_kegiatan_id)->first();
        $anggaran = Anggaran::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $dokumentasi = Dokumentasi::where('detail_kegiatan_id', $detail_kegiatan_id)->with('files')->get();
        $isEdit = true;
				$kegiatan = Kegiatan::where('id', $detail->kegiatan_id)->orderBy('created_at', 'desc')->first();
				$penanggung = PenanggungJawab::where('kegiatan_id', $kegiatan->id)->first();
				$program = Program::where('id', $kegiatan->program)->first();
				$kegiatan->penanggung = $penanggung;
				$kegiatan->program = $program->name;
        $totalbelanjaOperasi = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Operasi')->sum('daya_serap_kontrak');
				$totalbelanjaModal = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Modal')->sum('daya_serap_kontrak');
				$totalbelanjaTakTerduga = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Tak Terduga')->sum('daya_serap_kontrak');
				$totalbelanjaTransfer = Anggaran::where('detail_kegiatan_id', '=', $detail->id)->where('daya_serap','Belanja Transfer')->sum('daya_serap_kontrak');
        $totalOperasi = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_operasi');
				$totalModal = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_modal');
				$totalTakTerduga = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_tak_terduga');
				$totalTransfer = Pengambilan::where('detail_kegiatan_id', '=', $detail->id)->sum('belanja_transfer');
        $pengambilan = Pengambilan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        return view('backend.kegiatan.edit_anggaran', 
        compact(
          'detail', 
          'anggaran', 
          'dokumentasi', 
          'isEdit',
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
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnggaranRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnggaranRequest $request): RedirectResponse
    {
				$detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
        $anggaran = Anggaran::updateOrCreate([
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => $request->daya_serap,
        ],
        [
          'detail_kegiatan_id' => $request->detail_kegiatan_id,
          'daya_serap' => $request->daya_serap,
          'sisa' => 0,
          'tanggal' => $request->tanggal,
          'keterangan' => $request->keterangan ?? null,
          'daya_serap_kontrak' => $request->daya_serap_kontrak ?? null,
          'sisa_kontrak' => $request->sisa_kontrak ?? 0,
          'sisa_anggaran' => $request->sisa_anggaran ?? 0,
          'progress' => 0
        ]);
				$totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('daya_serap_kontrak');
				$detailKegiatan->update([
          'pagu' => $totalDayaSerap
				]);
        if($anggaran) {
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil disimpan')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
        => $request->detail_kegiatan_id])->with('error', 'Data Anggaran gagal disimpan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnggaranRequest $request
     * @param Anggaran $anggaran
     * @return RedirectResponse
     */
    public function update(UpdateAnggaranRequest $request, Anggaran $anggaran): RedirectResponse
    {
				$detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
        if($anggaran->update([
            'daya_serap' => $request->daya_serap,
            'daya_serap_kontrak' => $request->daya_serap_kontrak,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan ?? null,
						'progress' => 0
        ])) {
					$totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('daya_serap_kontrak');
					$detailKegiatan->update([
						'pagu' => $totalDayaSerap
					]);
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil diubah')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
        => $request->detail_kegiatan_id])->with('error', 'Data Anggaran gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Anggaran $anggaran
     * @return RedirectResponse
     */
    public function destroy(Anggaran $anggaran): RedirectResponse
    {
			$detailId = $anggaran->detail_kegiatan_id;
			$detailKegiatan = DetailKegiatan::where('id', $detailId)->first();
        if($anggaran->delete()) {
					$totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailId)->sum('daya_serap_kontrak');
					$detailKegiatan->update([
						'pagu' => $totalDayaSerap
					]);
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
            => $anggaran->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil dihapus')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
        => $anggaran->detail_kegiatan_id])->with('error', 'Data Anggaran gagal dihapus');
    }
}
