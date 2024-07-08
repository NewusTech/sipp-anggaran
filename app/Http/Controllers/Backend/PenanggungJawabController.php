<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;

class PenanggungJawabController extends Controller
{
    public function index()
    {
        try {
            $penanggungJawab = PenanggungJawab::all();
            return view('backend.penanggung-jawab.index', compact('penanggungJawab'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
