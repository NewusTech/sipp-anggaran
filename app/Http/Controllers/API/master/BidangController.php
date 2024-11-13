<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BidangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function index(Request $request)
    {

        $seach = $request->query('search');
        $count = $request->query('count', 10);

        $bidang = Bidang::orderBy('created_at', 'desc')
            ->when($seach, function ($query) use ($seach) {
                $query->where('name', 'like', '%' . $seach . '%');
            })
            ->paginate($count);
        return response()->json([
            'success' => true,
            'data' => $bidang
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'kode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $bidang = Bidang::create([
            'name' => $request->name,
            'kode' => $request->kode,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
        ]);
    }

    public function show($id)
    {
        $bidang = Bidang::find($id);

        if (!$bidang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $bidang
        ]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'kode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $bidang = Bidang::find($id);

        if (!$bidang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        $bidang->name = $request->name;
        $bidang->kode = $request->kode;
        $bidang->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function destroy($id)
    {
        $bidang = Bidang::find($id);

        if (!$bidang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        $bidang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
