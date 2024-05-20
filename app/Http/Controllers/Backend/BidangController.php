<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bidang = Bidang::orderBy('created_at', 'desc')->get();
        return view('backend.bidang.index', compact('bidang'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'kode' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('backend.bidang.index')
                          ->withErrors($validator)
                          ->withInput();
        }
  
        $bidang = Bidang::create([
            'name' => $request->name,
            'kode' => $request->kode,
        ]);
        return redirect()->route('backend.bidang.index')->with('success', 'Bidang berhasil disimpan');
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
        $user = Bidang::where('id', '=',$id)->update([
            'name' => $request->name,
            'kode' => $request->kode,
        ]);
        return redirect()->route('backend.bidang.index')->with('success', 'Bidang berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bidang = Bidang::where('id',$id)->first();
        $bidang->delete();
        return redirect()->route('backend.bidang.index')->with('success', 'Bidang berhasil dihapus');
    }
}
