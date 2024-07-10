<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Anggaran\StoreAnggaranRequest;
use App\Http\Requests\Backend\Anggaran\UpdateAnggaranRequest;
use App\Models\Anggaran;
use App\Models\Bidang;
use App\Models\DetailKegiatan;
use App\Models\ProgresKegiatan;
use App\Models\RencanaKegiatan;
use App\Models\Dokumentasi;
use Carbon\Carbon;
use App\Models\Kegiatan;
use App\Models\PenanggungJawab;
use App\Models\Program;
use App\Models\Pengambilan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
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
        $kurvaS = RencanaKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $kegiatan->penanggung = $penanggung;
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
            'backend.kegiatan.detail_anggaran',
            compact(
                'detail',
                'anggaran',
                'dokumentasi',
                'isEdit',
                'kegiatan',
                'kurvaS',
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
     * Display the specified resource.
     *
     * @param $detail_kegiatan_id
     * @return Application|Factory|View
     */
    public function show($detail_kegiatan_id): View|Factory|Application|RedirectResponse
    {
        try {
            $bidang = Bidang::all();
            $detail = DetailKegiatan::with('penyedia')->where('id', $detail_kegiatan_id)->first();
            $anggaran = Anggaran::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
            $dokumentasi = Dokumentasi::where('detail_kegiatan_id', $detail_kegiatan_id)->with('files')->get();
            $isEdit = true;
            $kegiatan = Kegiatan::where('id', $detail->kegiatan_id)->orderBy('created_at', 'desc')->first();
            $penanggung = PenanggungJawab::where('id', $detail->penanggung_jawab_id)->first();
            $listPJ = PenanggungJawab::select('id', 'pptk_name')->get();
            $program = Program::where('id', $kegiatan->program)->first();
            $progres = ProgresKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
            $progresFisik = $progres->where('jenis_progres', 'fisik');
            $progresKeuangan = $progres->where('jenis_progres', 'keuangan');
            $kegiatan->penanggung = $penanggung;
            $kegiatan->program = $program->name;
            $kurvaS = RencanaKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
            $bulanKurvaS = $kurvaS->pluck('bulan')->map(function ($bulan) {
                return Carbon::parse($bulan)->locale('id')->isoFormat('MMMM');
            })->toArray();
            $dataBulan = ['keuangan' => $kurvaS->pluck('keuangan'), 'fisik' => $kurvaS->pluck('fisik')];
            $dataBulan = json_encode($dataBulan);
            $dataProgresFisik = json_encode($progresFisik->map(function ($progres) {
                return [
                    'nilai' => $progres->nilai,
                    'tanggal' => $progres->tanggal,
                ];
            }));
            $bulan = json_encode($bulanKurvaS);
            if (count($progresFisik) > count($bulanKurvaS)) {
                foreach (array_slice($progresFisik->toArray(), count($bulanKurvaS)) as $progres) {
                    $bulanKurvaS[] = Carbon::parse($progres['tanggal'])->locale('id')->isoFormat('MMMM');
                }
            }
            $bulan = json_encode($bulanKurvaS);
            return view(
                'backend.kegiatan.edit_anggaran',
                compact(
                    'bidang',
                    'detail',
                    'anggaran',
                    'dokumentasi',
                    'isEdit',
                    'kegiatan',
                    'kurvaS',
                    'bulan',
                    'dataBulan',
                    'program',
                    'progresFisik',
                    'dataProgresFisik',
                    'progresKeuangan',
                    'listPJ'
                )
            );
        } catch (Exception $exception) {
            return redirect()->route('backend.kegiatan.index')->with('error', "Data tidak ditemukan");
        }
    }

    public function edit($detail_kegiatan_id): View|Factory|Application
    {
        $bidang = Bidang::all();
        $detail = DetailKegiatan::with('penyedia')->where('id', $detail_kegiatan_id)->first();
        $anggaran = Anggaran::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $dokumentasi = Dokumentasi::where('detail_kegiatan_id', $detail_kegiatan_id)->with('files')->get();
        $isEdit = true;
        $kegiatan = Kegiatan::where('id', $detail->kegiatan_id)->orderBy('created_at', 'desc')->first();
        $penanggung = PenanggungJawab::where('kegiatan_id', $kegiatan->id)->first();
        $program = Program::where('id', $kegiatan->program)->first();
        $progres = ProgresKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $progresFisik = $progres->where('jenis_progres', 'fisik');
        $progresKeuangan = $progres->where('jenis_progres', 'keuangan');
        $kegiatan->penanggung = $penanggung;
        $kegiatan->program = $program->name;
        $kurvaS = RencanaKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
        $bulanKurvaS = $kurvaS->pluck('bulan')->map(function ($bulan) {
            return Carbon::parse($bulan)->locale('id')->isoFormat('MMMM');
        })->toArray();
        $dataBulan = ['keuangan' => $kurvaS->pluck('keuangan'), 'fisik' => $kurvaS->pluck('fisik')];
        $bulan = json_encode($bulanKurvaS);
        $dataBulan = json_encode($dataBulan);
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
            'backend.kegiatan.edit_anggaran',
            compact(
                'bidang',
                'detail',
                'anggaran',
                'dokumentasi',
                'isEdit',
                'kegiatan',
                'kurvaS',
                'bulan',
                'dataBulan',
                'progresFisik',
                'progresKeuangan',
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
     * Store a newly created resource in storage.
     *
     * @param StoreAnggaranRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnggaranRequest $request): RedirectResponse
    {
        $detailKegiatan = DetailKegiatan::where('id', $request->detail_kegiatan_id)->first();
        $anggaran = Anggaran::updateOrCreate(
            [
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
            ]
        );
        $totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailKegiatan->id)->sum('daya_serap_kontrak');
        $detailKegiatan->update([
            'pagu' => $totalDayaSerap
        ]);
        if ($anggaran) {
            return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil disimpan')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id'
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
        if ($anggaran->update([
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
            return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil diubah')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id'
        => $request->detail_kegiatan_id])->with('error', 'Data Anggaran gagal diubah');
    }

    public function updateKurva(Request $request, $detail_kegiatan_id)
    {

        $dataBaru = $request->input('data');

        foreach ($dataBaru as $data) {
            $rencanaKegiatan = RencanaKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)
                ->where('minggu', $data['minggu'])->where('bulan', $data['bulan'])->update([
                    // 'keuangan' => $data['keuangan'],
                    'fisik' => $data['fisik']
                ]);
            // dd($data['bulan'], $rencanaKegiatan->get());

            // $rencana = RencanaKegiatan::where('detail_kegiatan_id', $detail_kegiatan_id)->get();
            // dd($data['keuangan'], $data['fisik'], $rencana);
        }

        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail_kegiatan_id])->with('success', 'Data kurva berhasil diperbarui.')->with('tab', 'kurva_s');
    }


    public function addProgres(Request $request, $detail_kegiatan_id)
    {
        $progres = new ProgresKegiatan();
        $progres->detail_kegiatan_id = $detail_kegiatan_id;
        $progres->tanggal = $request->tanggal;
        $progres->nilai = $request->nilai;
        $progres->jenis_progres = $request->jenis_progres;
        $progres->save();

        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $detail_kegiatan_id])->with('success', 'Progres kegiatan berhasil ditambahkan')->with('tab', 'kurva_s');
    }

    public function updateProgres(Request $request, $id)
    {

        $progres = ProgresKegiatan::find($id);
        $progres->update([
            'tanggal' => $request->tanggal,
            'nilai' => $request->nilai
        ]);

        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id' => $progres->detail_kegiatan_id])->with('success', 'Progres kegiatan berhasil diperbarui')->with('tab', 'kurva_s');
    }

    public function deleteProgres($id)
    {

        $progres = ProgresKegiatan::find($id);
        $progres->delete();

        return redirect()->route('backend.detail_anggaran.index',  ['detail_kegiatan_id' => $progres->detail_kegiatan_id])->with('success', 'Progres kegiatan berhasil dihapus')->with('tab', 'kurva_s');
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
        if ($anggaran->delete()) {
            $totalDayaSerap = Anggaran::where('detail_kegiatan_id', '=', $detailId)->sum('daya_serap_kontrak');
            $detailKegiatan->update([
                'pagu' => $totalDayaSerap
            ]);
            return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id'
            => $anggaran->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil dihapus')->with('tab', 'anggaran');
        }
        return redirect()->route('backend.detail_anggaran.index', ['detail_kegiatan_id'
        => $anggaran->detail_kegiatan_id])->with('error', 'Data Anggaran gagal dihapus');
    }
}
