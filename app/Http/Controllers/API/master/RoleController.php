<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function getPermision()
    {
        $permisions = Permission::all();

        return response()->json([
            'status' => 'success',
            'data' => $permisions
        ]);
    }

    public function index(Request $request)
    {
        $seacth = $request->query('search');
        $count = $request->query('count', 10);

        try {
            $roles = Role::orderBy('created_at', 'desc')
                ->when($seacth, function ($query) use ($seacth) {
                    $query->where('name', 'like', '%' . $seacth . '%');
                })
                ->paginate($count);


            return response()->json([
                'success' => true,
                'data' => $roles,
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
