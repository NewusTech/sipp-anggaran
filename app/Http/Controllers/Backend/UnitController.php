<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
  /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
			$unit = Unit::orderBy('created_at', 'desc')->get();
			return view('backend.unit.index', compact('unit'));
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
					return redirect()->route('backend.unit.index')
												->withErrors($validator)
												->withInput();
			}

			$unit = Unit::create([
					'name' => $request->name,
					'kode' => $request->kode,
			]);
			return redirect()->route('backend.unit.index')->with('success', 'unit berhasil disimpan');
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
			$unit = Unit::where('id', '=',$id)->update([
					'name' => $request->name,
					'kode' => $request->kode,
			]);
			return redirect()->route('backend.unit.index')->with('success', 'unit berhasil disimpan');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
			$unit = Unit::where('id',$id)->first();
			$unit->delete();
			return redirect()->route('backend.unit.index')->with('success', 'unit berhasil dihapus');
	}
}
