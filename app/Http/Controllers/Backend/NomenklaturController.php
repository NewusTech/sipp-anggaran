<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Nomenklatur;
use Illuminate\Http\Request;

class NomenklaturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomenklatur = Nomenklatur::orderBy('created_at', 'desc')->first();
        return view('backend.nomenklatur.index', compact('nomenklatur'));
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
        if ($request->has('id') && $request->id != '') {
            $user = Nomenklatur::where('id', '=',$request->id)->update([
                'pptk' => $request->pptk,
                'ppk' => $request->ppk,
            ]);
        }else{
            $user = Nomenklatur::create([
                'pptk' => $request->pptk,
                'ppk' => $request->ppk,
            ]);
        }
        
        return redirect()->route('backend.nomenklatur.index')->with('success', 'Nomenklatur berhasil disimpan');
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
        $user = Nomenklatur::where('id', '=',$id)->update([
            'pptk' => $request->pptk,
            'ppk' => $request->ppk,
        ]);
        return redirect()->route('backend.nomenklatur.index')->with('success', 'Nomenklatur berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nomenklatur = Nomenklatur::where('id',$id)->first();
        $nomenklatur->delete();
        return redirect()->route('backend.nomenklatur.index')->with('success', 'Nomenklatur berhasil dihapus');
    }
}
