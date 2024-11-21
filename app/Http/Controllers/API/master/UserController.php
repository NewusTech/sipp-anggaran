<?php

namespace App\Http\Controllers\API\master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Avatar;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }

    public function getListRole()
    {

        $user_role = auth('api')->user()->getRoleNames();
        if ($user_role[0] == 'Super Admin') {
            $roles = Role::all();
        } else {
            $roles = Role::where('name', '!=', 'Super Admin')->get();
        }

        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    public function index(Request $request)
    {
        $seacth = $request->query('search');
        $count = $request->query('count', 10);

        try {
            $users = User::orderBy('created_at', 'desc')
                ->with('bidang:id,name')
                ->when($seacth, function ($query) use ($seacth) {
                    $query->where('name', 'like', '%' . $seacth . '%');
                })
                ->paginate($count);

            $users->map(function ($user) {
                $user->role = $user->getRoleNames();
                return $user;
            });

            return response()->json([
                'success' => true,
                'data' => $users,
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
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'Data not found',
                ], 404);
            }

            $user->bidang = $user->bidang;
            $user->role = $user->getRoleNames();
            // $user->role = $user->getRoleNames();

            return response()->json([
                'success' => true,
                'data' => $user,
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
        $validateData = Validator::make($request->all(), [
            'name' => 'required',
            'nip' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'username' => 'required|unique:users,username',
            'phone_number' => 'required',
            'roles' => 'required',
            'bidang_id' => 'nullable',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validateData->errors(),
            ]);
        }

        $avatar = new Avatar();
        $image = time() . ".png";
        $avatar->create($request->name)->save(public_path('uploads/' . $image));
        $saveImage = "profile_images/" . $image;

        $bidang_id = null;
        if (str_contains($request->roles, "Staff")) {
            if (auth('api')->user()->bidang_id != $request->bidang_id) {
                $bidang_id = $request->bidang_id;
            } else {
                $bidang_id = auth('api')->user()->bidang_id;
            }
        } else {
            $bidang_id = $request->bidang_id;
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'nip' => $request->nip,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $saveImage,
                'username' => $request->username,
                'bidang_id' => $bidang_id,
                'phone_number' => $request->phone_number
            ]);

            $user->assignRole($request->roles);

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required',
            'nip' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required',
            'phone_number' => 'required',
            'roles' => 'optional',
            'bidang_id' => 'optional',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validateData->errors(),
            ]);
        }
        try {

            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'Data not found',
                ], 404);
            }

            $bidang_id = null;
            if (str_contains($request->roles, "Staff")) {
                if (auth('api')->user()->bidang_id != $request->bidang_id) {
                    $bidang_id = $request->bidang_id;
                } else {
                    $bidang_id = auth('api')->user()->bidang_id;
                }
            } else {
                $bidang_id = $request->bidang_id;
            }

            $user->update([
                'name' => $request->name,
                'nip' => $request->nip,
                'email' => $request->email,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'bidang_id' => $bidang_id,
            ]);

            $user->syncRoles($request->roles);

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function updatePass(Request $request, $id)
    {
        $validateData = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validateData->errors(),
            ]);
        }

        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'Data not found',
                ], 404);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'data' => $user,
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
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'Data not found',
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully',
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
