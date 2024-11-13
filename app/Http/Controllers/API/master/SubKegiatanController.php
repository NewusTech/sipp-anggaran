<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubKegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }
    public function getkegiatan()
    {
        $kegiatan = Kegiatan::select('id', 'title')->get();
        return response()->json([
            'success' => true,
            'data' => $kegiatan,
        ]);
    }

    public function index(Request $request)
    {
        $seach = $request->query('search');
        $count = $request->query('count', 10);

        try {

            $subkegiatan = SubKegiatan::orderBy('created_at', 'desc')
                ->when($seach, function ($query) use ($seach) {
                    $query->where('title', 'like', '%' . $seach . '%');
                })
                ->paginate($count);

            return response()->json([
                'success' => true,
                'data' => $subkegiatan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $subkegiatan = SubKegiatan::find($id);

        if (!$subkegiatan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subkegiatan,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'kegiatan_id' => 'required',
            'kode_sub_kegiatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $subkegiatan = SubKegiatan::create([
                'title' => $request->title,
                'kegiatan_id' => $request->kegiatan_id,
                'kode_sub_kegiatan' => $request->kode_sub_kegiatan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'kegiatan_id' => 'required',
            'kode_sub_kegiatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $subkegiatan = SubKegiatan::find($id);

        if (!$subkegiatan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        try {
            $subkegiatan->update([
                'title' => $request->title,
                'kegiatan_id' => $request->kegiatan_id,
                'kode_sub_kegiatan' => $request->kode_sub_kegiatan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $subkegiatan = SubKegiatan::find($id);

        if (!$subkegiatan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        try {
            $subkegiatan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
