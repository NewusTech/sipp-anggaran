<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;

class SubKegiatanController extends Controller
{
    public function index(Request $request) {
        $seach = $request->query('search');
        $count = $request->query('count', 10);

        try{

        $subKategori = SubKegiatan::orderBy('created_at', 'desc')
            ->when($seach, function ($query) use ($seach) {
                $query->where('name', 'like', '%' . $seach . '%');
            })
            ->paginate($count);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
