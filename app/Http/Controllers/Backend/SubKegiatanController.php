<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dpa;
use App\Models\Pagu;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\Pengambilan;
use App\Models\DetailKegiatan;
use App\Models\Anggaran;
use App\Models\Bidang;
use App\Models\Program;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class SubKegiatanController extends Controller
{
    public function index()
    {
        try {
            $bidangs = Bidang::get(['id', 'name']);
            $programs = Program::get(['id', 'name']);
            $kegiatans = Kegiatan::with('bidang')->orderBy('bidang_id')->get(['id', 'title', 'bidang_id', 'program', 'tahun', 'no_rek']);
            $kegiatans->map(function ($kegiatan) use ($programs) {
                $kegiatan->program_name = $programs->where('id', $kegiatan->program)->first()->name;
            });
            $subKegiatan = SubKegiatan::with(['kegiatan'])->get(['id', 'kode_sub_kegiatan', 'kegiatan_id', 'title']);

            return view('backend.sub-kegiatan.index', compact(['subKegiatan', 'kegiatans', 'bidangs', 'programs']));
        } catch (\Exception $e) {
            return redirect()->route('backend.sub_kegiatan.index')->with('error', $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            $subKegiatan = SubKegiatan::create([
                'title' => $request->title,
                'kegiatan_id' => $request->kegiatan_id,
                'kode_sub_kegiatan' => $request->kode_sub_kegiatan
            ]);
            return redirect()->route('backend.sub_kegiatan.index')->with('success', 'Kegiatan berhasil disimpan')->with('step', 'sub_kegiatan');
        } catch (\Exception $e) {
            return redirect()->route('backend.sub_kegiatan.index')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $sub = SubKegiatan::where('id', $id)->first();
            $sub->update([
                'title' => $request->title,
                'kegiatan_id' => $request->kegiatan_id,
                'kode_sub_kegiatan' => $request->kode_sub_kegiatan
            ]);
            return redirect()->route('backend.sub_kegiatan.index')->with('success', 'Sub Kegiatan berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('backend.sub_kegiatan.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pengambilan $Pengambilan
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $sub = SubKegiatan::where('id', $id)->first();
            $sub->delete();
            return redirect()->route('backend.sub_kegiatan.index')->with('success', 'Sub Kegiatan berhasil di hapus');
        } catch (\Exception $e) {
            return redirect()->route('backend.sub_kegiatan.index')->with('error', $e->getMessage());
        }
    }
}
