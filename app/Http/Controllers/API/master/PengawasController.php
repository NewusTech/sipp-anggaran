<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengawasController extends Controller
{
    public function index(Request $request)
    {
        $seacth = $request->query('search');
        $count = $request->query('count', 10);
        try{
        $pengawas = PenanggungJawab::orderBy('created_at', 'desc')
            ->when($seacth, function ($query) use ($seacth) {
                $query->where('pptk_name', 'like', '%' . $seacth . '%')
                        ->orWhere('pptk_email', 'like', '%' . $seacth . '%')
                        ->orWhere('pptk_telpon', 'like', '%' . $seacth . '%')
                        ->orWhere('ppk_name', 'like', '%' . $seacth . '%')
                        ->orWhere('ppk_email', 'like', '%' . $seacth . '%')
                        ->orWhere('ppk_telpon', 'like', '%' . $seacth . '%');
            })
            ->paginate($count);;

        return response()->json([
            'success' => true,
            'data' => $pengawas
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pptk_name' => 'required',
            'pptk_email' => 'required',
            'pptk_telpon' => 'required',
            'ppk_name' => 'required',
            'ppk_email' => 'required',
            'ppk_telpon' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        try{
            $pengawas = PenanggungJawab::create([
                'pptk_name' => $request->pptk_name,
                'pptk_email' => $request->pptk_email,
                'pptk_telpon' => $request->pptk_telpon,
                'ppk_name' => $request->ppk_name,
                'ppk_email' => $request->ppk_email,
                'ppk_telpon' => $request->ppk_telpon,
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

    public function show($id)
    {
        try{
            $pengawas = PenanggungJawab::where('id', $id)->first();
            return response()->json([
                'success' => true,
                'data' => $pengawas
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
            'pptk_name' => 'required',
            'pptk_email' => 'required',
            'pptk_telpon' => 'required',
            'ppk_name' => 'required',
            'ppk_email' => 'required',
            'ppk_telpon' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }
        try{
            PenanggungJawab::where('id', $id)->update([
                'pptk_name' => $request->pptk_name,
                'pptk_email' => $request->pptk_email,
                'pptk_telpon' => $request->pptk_telpon,
                'ppk_name' => $request->ppk_name,
                'ppk_email' => $request->ppk_email,
                'ppk_telpon' => $request->ppk_telpon,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah',
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
        try{
            PenanggungJawab::where('id', $id)->delete();
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
