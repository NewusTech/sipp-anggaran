<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SumberDana;
use Illuminate\Support\Facades\Validator;

class SumberDanaController extends Controller
{
  /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
			$sumberDana = SumberDana::orderBy('created_at', 'desc')->get();
			return view('backend.sumber_dana.index', compact('sumberDana'));
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
					return redirect()->route('backend.sumberDana.index')
												->withErrors($validator)
												->withInput();
			}

			$sumberDana = SumberDana::create([
					'name' => $request->name,
					'kode' => $request->kode,
			]);
			return redirect()->route('backend.sumber_dana.index')->with('success', 'Sumber Dana berhasil disimpan');
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
			$sumberDana = SumberDana::where('id', '=',$id)->update([
					'name' => $request->name,
					'kode' => $request->kode,
			]);
			return redirect()->route('backend.sumber_dana.index')->with('success', 'Sumber Dana berhasil disimpan');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
			$sumberDana = SumberDana::where('id',$id)->first();
			$sumberDana->delete();
			return redirect()->route('backend.sumber_dana.index')->with('success', 'Sumber Dana berhasil dihapus');
	}
}
