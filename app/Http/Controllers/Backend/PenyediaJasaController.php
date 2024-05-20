<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PenyediaJasa;
use Illuminate\Http\Request;

class PenyediaJasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penyedia_jasa = PenyediaJasa::orderBy('created_at', 'desc')->get();
        return view('backend.penyedia_jasa.index', compact('penyedia_jasa'));
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
        $user = PenyediaJasa::create([
            'name' => $request->name,
            'telepon' => $request->telepon,
            'join_date' => $request->join_date,
        ]);
        return redirect()->route('backend.penyedia_jasa.index')->with('success', 'Penyedia Jasa berhasil disimpan');
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
        $user = PenyediaJasa::where('id', '=',$id)->update([
            'name' => $request->name,
            'telepon' => $request->telepon,
            'join_date' => $request->join_date,
        ]);
        return redirect()->route('backend.penyedia_jasa.index')->with('success', 'Penyedia Jasa berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penyedia_jasa = PenyediaJasa::where('id',$id)->first();
        $penyedia_jasa->delete();
        return redirect()->route('backend.penyedia_jasa.index')->with('success', 'Penyedia Jasa berhasil dihapus');
    }
}
