<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }
    public function getBidangAndProgram()
    {
        $bidang = Bidang::select('id', 'name')->get();
        $progrem = Program::select('id', 'name')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'bidang' => $bidang,
                'program' => $progrem,
            ],
        ]);
    }
    public function index(Request $request)
    {
        $seacth = $request->query('search');
        $count = $request->query('count', 10);

        try {
            $kegiatan = Kegiatan::orderBy('created_at', 'desc')
                ->select(['id', 'title', 'bidang_id', 'program'])
                ->with([
                    'bidang' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                    'program' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                ])
                ->when($seacth, function ($query) use ($seacth) {
                    $query->where('title', 'like', '%' . $seacth . '%');
                })
                ->paginate($count);

            return response()->json([
                'success' => true,
                'data' => $kegiatan,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'tahun' => 'required',
            'bidang_id' => 'required',
            'program' => 'required',
            'kode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors(),
                ],
                422,
            );
        }

        try {
            $kegiatan = Kegiatan::create([
                'title' => $request->title,
                'tahun' => $request->tahun,
                'bidang_id' => $request->bidang_id,
                'program' => $request->program,
                'no_rek' => $request->kode,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Data tidak ditemukan',
                ],
                404,
            );
        }
        return response()->json([
            'success' => true,
            'data' => $kegiatan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'tahun' => 'required',
            'bidang_id' => 'required',
            'program' => 'required',
            'kode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors(),
                ],
                422,
            );
        }

        try {
            $kegiatan = Kegiatan::where('id', $id)->first();

            $kegiatan->update([
                'title' => $request->title,
                'tahun' => $request->tahun,
                'bidang_id' => $request->bidang_id,
                'program' => $request->program,
                'no_rek' => $request->kode,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($id)
    {
        try {
            $kegiatan = Kegiatan::where('id', $id)->first();

            if (!$kegiatan) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Data tidak ditemukan',
                    ],
                    404,
                );
            }
            $kegiatan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
