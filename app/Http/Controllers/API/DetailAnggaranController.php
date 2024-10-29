<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailKegiatan;
use Illuminate\Http\Request;

class DetailAnggaranController extends Controller
{
    public function detail($detail_kegitan_id)
    {
        try {
            $detail = DetailKegiatan::find($detail_kegitan_id);
            return response()->json([
                'status' => 'success',
                'data' => $detail
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
