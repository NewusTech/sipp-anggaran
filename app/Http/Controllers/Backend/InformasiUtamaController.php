<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InformasiUtama;
use Illuminate\Http\Request;

class InformasiUtamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informasi_utama = InformasiUtama::orderBy('created_at', 'desc')->get();
        return view('backend.informasi_utama.index', compact('informasi_utama'));
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
        $user = InformasiUtama::create([
            'title' => $request->title,
            'versi' => $request->versi,
            'description' => $request->description,
        ]);
        return redirect()->route('backend.informasi_utama.index')->with('success', 'Informasi Utama berhasil disimpan');
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
        $user = InformasiUtama::where('id', '=',$id)->update([
            'title' => $request->title,
            'versi' => $request->versi,
            'description' => $request->description,
        ]);
        return redirect()->route('backend.informasi_utama.index')->with('success', 'Informasi Utama berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $informasi_utama = InformasiUtama::where('id',$id)->first();
        $informasi_utama->delete();
        return redirect()->route('backend.informasi_utama.index')->with('success', 'Informasi Utama berhasil dihapus');
    }
}
