<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Petunjuk\StorePetunjukRequest;
use App\Http\Requests\Backend\Petunjuk\UpdatePetunjukRequest;
use App\Models\Petunjuk;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PetunjukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $petunjuk = Petunjuk::all();
        return view('backend.petunjuk.index', compact('petunjuk', ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePetunjukRequest $request
     * @return RedirectResponse
     */
    public function store(StorePetunjukRequest $request): RedirectResponse
    {
        $petunjuk = Petunjuk::create([
            'title' => $request->title,
            'detail' => $request->detail
        ]);
        if($petunjuk) {
            return redirect()->route('backend.petunjuk.index')->with('success', 'Petunjuk berhasil disimpan');
        }
        return redirect()->route('backend.petunjuk.index')->with('success', 'Petunjuk gagal disimpan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePetunjukRequest $request
     * @param Petunjuk $petunjuk
     * @return Response
     */
    public function update(UpdatePetunjukRequest $request, Petunjuk $petunjuk)
    {
        if($petunjuk->update([
            'title' => $request->title,
            'detail' => $request->detail
        ])) {
            return redirect()->route('backend.petunjuk.index')->with('success', 'Petunjuk berhasil diubah');
        }
        return redirect()->route('backend.petunjuk.index')->with('error', 'Petunjuk gagal diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Petunjuk $petunjuk)
    {
        if($petunjuk->delete()) {
            return redirect()->route('backend.petunjuk.index')->with('success', 'Petunjuk berhasil dihapus');
        }
        return redirect()->route('backend.petunjuk.index')->with('error', 'Petunjuk gagal dihapus');
    }
}
