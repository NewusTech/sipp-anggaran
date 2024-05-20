<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InformasiTagihan;
use Illuminate\Http\Request;

class InformasiTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informasi_tagihan = InformasiTagihan::orderBy('created_at', 'desc')->get();
        return view('backend.informasi_tagihan.index', compact('informasi_tagihan'));
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
        $user = InformasiTagihan::create([
            'name' => $request->name,
            'join_date' => $request->join_date,
        ]);
        return redirect()->route('backend.informasi_tagihan.index')->with('success', 'InformasiTagihan berhasil disimpan');
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
        $user = InformasiTagihan::where('id', '=',$id)->update([
            'name' => $request->name,
            'join_date' => $request->join_date,
        ]);
        return redirect()->route('backend.informasi_tagihan.index')->with('success', 'InformasiTagihan berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $informasi_tagihan = InformasiTagihan::where('id',$id)->first();
        $informasi_tagihan->delete();
        return redirect()->route('backend.informasi_tagihan.index')->with('success', 'InformasiTagihan berhasil dihapus');
    }
}
