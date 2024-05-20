<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\TandaTangan;
use Illuminate\Http\Request;

class TandaTanganController extends Controller
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
  
        $tandaTangan = TandaTangan::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'dpa_id' => $request->dpa_id,
        ]);
        return redirect()->route('backend.dpa.show',$request->dpa_id)->with('success', 'Tanda Tangan berhasil disimpan')->with('step', 'tanda_tangan');
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
        $user = TandaTangan::where('id', '=',$id)->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'dpa_id' => $request->dpa_id,
        ]);
        return redirect()->route('backend.dpa.show',$request->dpa_id)->with('success', 'Tanda Tangan berhasil disimpan')->with('step', 'tanda_tangan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $tandaTangan = TandaTangan::where('id',$id)->first();
        $tandaTangan->delete();
        return redirect()->route('backend.dpa.show',$request->dpa_id)->with('success', 'Tanda Tangan berhasil dihapus')->with('step', 'tanda_tangan');
    }
}
