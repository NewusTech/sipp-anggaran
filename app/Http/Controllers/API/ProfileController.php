<?php

namespace App\Http\Controllers\apI;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'logout']]);
    }
    public function index()
    {
        try {
            $user_data = User::findOrFail(auth()->user()->id);

            return response()->json([
                'status' => 'success',
                'data' => $user_data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . auth()->user()->id,
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone_number' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Profile berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        try {
            $user = User::findOrFail(auth()->user()->id);
            if ($request->file('image') == "") {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal mengubah gambar'
                ]);
            } else {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $type = $image->getMimeType();
                $path = 'profile_images/' . $filename;
                Storage::disk('local')->put($path, file_get_contents($image));
                if (!is_null($user->image)) {
                    if (Storage::disk('public')->exists($user->image)) {
                        Storage::disk('public')->delete($user->image);
                    }
                }
                $user->update([
                    'image' => $path
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Gambar profil berhasil diperbarui'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
