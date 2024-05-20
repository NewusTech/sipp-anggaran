<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Dokumentasi\StoreDokumentasiRequest;
use App\Http\Requests\Backend\Dokumentasi\UpdateDokumentasiRequest;
use App\Models\Dokumentasi;
use App\Models\FileDokumentasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDokumentasiRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDokumentasiRequest $request): RedirectResponse
    {
        $dokumentasi = new Dokumentasi();
        $dokumentasi->detail_kegiatan_id = $request->detail_kegiatan_id;
        $dokumentasi->name = $request->name;
        $dokumentasi->keterangan = $request->keterangan ?? null;

        if ($dokumentasi->save() && $request->file_name) {
            //store file dokumentasi
            $file = $request->file_name;

            foreach ($file as $val) {
                $filename = $val->getClientOriginalName();
                $type = $val->getMimeType();
                $path = 'file/dokumentasi/'.$filename;

                $fileDokumentasi = FileDokumentasi::create([
                    'dokumentasi_id' => $dokumentasi->id,
                    'file_name' => $filename,
                    'type' => $type,
                    'path' => $path
                ]);

                if ($fileDokumentasi) {
                    Storage::disk('local')->put($path, file_get_contents($val));
                }
            }
        }

        if ($dokumentasi) {
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $request->detail_kegiatan_id])
                ->with('success', 'File dokumentasi berhasil disimpan')->with('tab', 'dokumentasi');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $request->detail_kegiatan_id])
            ->with('error', 'File dokumentasi gagal disimpan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDokumentasiRequest $request
     * @param Dokumentasi $dokumentasi
     * @return RedirectResponse
     */
    public function update(UpdateDokumentasiRequest $request, Dokumentasi $dokumentasi): RedirectResponse
    {
        if($dokumentasi->update([
            'name' => $request->name,
            'keterangan' => $request->keterangan ?? null,
        ])) {

            if ($request->file_name) {
                $file = $request->file_name;

                foreach ($file as $val) {
                    $filename = $val->getClientOriginalName();
                    $type = $val->getMimeType();
                    $path = 'file/dokumentasi/'.$filename;

                    $check = FileDokumentasi::where('dokumentasi_id', $dokumentasi->id)->where('file_name', $filename)->get();
                    if (count($check) == 0) {
                        $fileDokumentasi = FileDokumentasi::create([
                            'dokumentasi_id' => $dokumentasi->id,
                            'file_name' => $filename,
                            'type' => $type,
                            'path' => $path
                        ]);

                        if ($fileDokumentasi) {
                            Storage::disk('local')->put($path, file_get_contents($val));
                        }
                    }
                }
            }

            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
            => $request->detail_kegiatan_id])->with('success', 'Data Anggaran berhasil diubah')->with('tab', 'dokumentasi');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id'
        => $request->detail_kegiatan_id])->with('error', 'Data Anggaran gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dokumentasi $dokumentasi
     * @return RedirectResponse
     */
    public function destroy(Dokumentasi $dokumentasi): RedirectResponse
    {
        if($dokumentasi->delete()) {
            $fileDokumentasi = FileDokumentasi::where('dokumentasi_id', $dokumentasi->id)->get();

            if (count($fileDokumentasi) > 0) {
                foreach ($fileDokumentasi as $val) {
                    if ($val->delete()) {
                        if (Storage::disk('local')->exists($val->path)) {
                            Storage::disk('local')->delete($val->path);
                        }
                    }
                }
            }
            return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $dokumentasi->detail_kegiatan_id])
                ->with('success', 'Data Dokumentasi berhasil dihapus')->with('tab', 'dokumentasi');
        }
        return redirect()->route('backend.detail_anggaran.edit', ['detail_kegiatan_id' => $dokumentasi->detail_kegiatan_id])
            ->with('error', 'Data Dokumentasi gagal dihapus');
    }
}
