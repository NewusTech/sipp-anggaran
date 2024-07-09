<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PenanggungJawab;
use Exception;
use Illuminate\Http\Request;

class PenanggungJawabController extends Controller
{
    public function index()
    {
        try {
            $penanggungJawab = PenanggungJawab::all();
            return view('backend.penanggung-jawab.index', compact('penanggungJawab'))->with('success', 'Penanggung jawab berhasil di tambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $penanggungJawab = PenanggungJawab::where('id', $id)->get();
            return view('backend.penanggung-jawab.show', compact('penanggungJawab'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            PenanggungJawab::create([
                'pptk_name' => $request->pptk_name,
                'pptk_email' => $request->pptk_email,
                'pptk_telpon' => $request->pptk_telpon,
                'ppk_name' => $request->ppk_name,
                'ppk_email' => $request->ppk_email,
                'ppk_telpon' => $request->ppk_telpon,
            ]);
            return redirect()->back()->with('success', 'Penanggung jawab berhasil di tambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            PenanggungJawab::where('id', $id)->update([
                'pptk_name' => $request->pptk_name,
                'pptk_email' => $request->pptk_email,
                'pptk_telpon' => $request->pptk_telpon,
                'ppk_name' => $request->ppk_name,
                'ppk_email' => $request->ppk_email,
                'ppk_telpon' => $request->ppk_telpon,
            ]);
            return redirect()->back()->with('success', 'Penanggung jawab berhasil di ubah');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            PenanggungJawab::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Penanggung jawab berhasil di hapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
