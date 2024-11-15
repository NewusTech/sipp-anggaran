<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\Nomenklatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NomenKlaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function index()
    {
        $nomenklatur = Nomenklatur::orderBy('created_at', 'desc')->first();
        return response()->json([
            'success' => true,
            'data' => $nomenklatur,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pptk' => 'required',
            'ppk' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ]);
        }

        if ($request->has('id') && $request->id != '') {
            $user = Nomenklatur::where('id', '=', $request->id)->update([
                'pptk' => $request->pptk,
                'ppk' => $request->ppk,
            ]);
        } else {
            $user = Nomenklatur::create([
                'pptk' => $request->pptk,
                'ppk' => $request->ppk,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Nomenklatur berhasil disimpan',
        ]);
    }
}
