<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\PenggunaAnggaran;
use Illuminate\Http\Request;

class PenggunaAnggaranController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nip' => 'required',
            'jabatan' => 'required',
            'dpa_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('backend.dpa.show',$request->dpa_id)
                          ->withErrors($validator)
                          ->withInput();
        }
  
        $PenggunaAnggaran = PenggunaAnggaran::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'dpa_id' => $request->dpa_id,
        ]);
        return redirect()->route('backend.dpa.show',$request->dpa_id)->with('success', 'Pengguana Anggaran berhasil disimpan')->with('step', 'pengguna_anggaran');
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
        $user = PenggunaAnggaran::where('id', '=',$id)->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'dpa_id' => $request->dpa_id,
        ]);
        return redirect()->route('backend.dpa.show',$request->dpa_id)->with('success', 'Pengguana Anggaran berhasil disimpan')->with('step', 'pengguna_anggaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $PenggunaAnggaran = PenggunaAnggaran::where('id',$id)->first();
        $PenggunaAnggaran->delete();
        return redirect()->route('backend.dpa.show',$request->dpa_id)->with('success', 'Pengguana Anggaran berhasil dihapus')->with('step', 'pengguna_anggaran');
    }
}
