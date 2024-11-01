<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiantanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }


    public function index(Request $request)
    {
        $year = $request->query('year', date('Y'));

        $user = auth('api')->user();
        $role = $user->getRoleNames();
        $bidang_id = $user->bidang_id;
        try {

            $bidang = Bidang::select('id', 'name', 'kode')
                ->with([
                    'kegiatan' => function ($query) use ($year) {
                        $query->select('id', 'title', 'bidang_id', 'created_at')
                            ->whereYear('created_at', $year);
                    },
                    'kegiatan.subKegiatan' => function ($query) {
                        $query->select('id', 'kegiatan_id', 'title', 'kode_sub_kegiatan', 'created_at');
                        // ->whereYear('created_at', $year);
                    },
                    'kegiatan.subKegiatan.detail' => function ($query) {
                        $query->select('id', 'sub_kegiatan_id', 'title', 'created_at')
                            ->with(['progres' => function ($query) {
                                $query->orderByDesc('nilai')
                                    ->where('jenis_progres', 'fisik')
                                    ->select('id', 'nilai', 'detail_kegiatan_id');
                            }]);
                    }
                ])->get();


            return response()->json([
                'success' => true,
                'message' => 'Get Kegiatan Success',
                'data' => $bidang
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
