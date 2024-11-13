<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $seacth = $request->query('search');
        $count = $request->query('count', 10);

        try {

            $kegiatan = Kegiatan::orderBy('created_at', 'desc')
                ->select(['id', 'title','bidang_id', 'program'])
                ->with(['bidang' => function($query) {
                    $query->select(['id', 'name']);
                }, 'program' => function($query) {
                    $query->select(['id', 'name']);
                }])
                ->when($seacth, function ($query) use ($seacth) {
                    $query->where('name', 'like', '%' . $seacth . '%');
                })
                ->paginate($count);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
