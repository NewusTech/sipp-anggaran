<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganisasiController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
			$organisasi = Organisasi::orderBy('created_at', 'desc')->get();
			return view('backend.organisasi.index', compact('organisasi'));
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
					return redirect()->route('backend.organisasi.index')
												->withErrors($validator)
												->withInput();
			}

			$organisasi = Organisasi::create([
					'name' => $request->name,
					'kode' => $request->kode,
			]);
			return redirect()->route('backend.organisasi.index')->with('success', 'organisasi berhasil disimpan');
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
			$organisasi = Organisasi::where('id', '=',$id)->update([
					'name' => $request->name,
					'kode' => $request->kode,
			]);
			return redirect()->route('backend.organisasi.index')->with('success', 'organisasi berhasil disimpan');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
			$organisasi = Organisasi::where('id',$id)->first();
			$organisasi->delete();
			return redirect()->route('backend.organisasi.index')->with('success', 'organisasi berhasil dihapus');
	}
}
