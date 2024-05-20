<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Kegiatan;
use App\Models\Bidang;
use App\Models\DetailKegiatan;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arsip()
    {
        $tahun = Kegiatan::select(DB::raw('count(id) as `data`'), 'tahun')
        ->where('is_arship', 1)
        ->groupby('tahun')
        ->orderBy('tahun', 'asc')
        ->get();
        $bidang = Bidang::orderBy('created_at', 'desc')
        ->get();
        $tahun->map(function ($item){
            $kegiatan = Kegiatan::where('tahun', $item->tahun)->where('is_arship', 1)->orderBy('created_at', 'desc')->get();
            $kegiatan->map(function ($query){
                $detailKegiatan = DetailKegiatan::where('kegiatan_id', $query->id)->orderBy('created_at', 'desc')->get();
                $query->detail_kegiatan = $detailKegiatan;
            });
            $item->kegiatan = $kegiatan;
        });
        return view('backend.arsip.index', compact(['tahun','bidang']));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
