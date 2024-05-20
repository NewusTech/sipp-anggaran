<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\StoreUserRequest;
use App\Http\Requests\Backend\User\UpdateUserRequest;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $users = User::with('bidang:id,name')->get();
        $roles = Role::all();
        $bidang = Bidang::all();
        return view('backend.user.index', compact('users', 'roles', 'bidang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $user = new User();
        $roles = Role::all();
        $bidang = Bidang::all();
        return view('backend.user.create', compact('user', 'roles', 'bidang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $avatar = new Avatar();
        $image = time() . ".png";
        $avatar->create($request->name)->save(public_path('uploads/' . $image));
        $saveImage = "profile_images/" . $image;
        $bidang_id = null;
        if (str_contains($request->roles[0], "Staff")) {
            $bidang_id = Auth::user()->bidang_id;
        }else{
            $bidang_id = $request->bidang_id;
        }
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
        return redirect()->route('backend.users.index')->with('success', 'Pengguna berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user): View|Factory|Application
    {
        return view('backend.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user): View|Factory|Application
    {
        $roles = Role::all();
        return view('backend.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $bidang_id = null;
        if (str_contains($request->roles[0], "Staff")) {
            $bidang_id = Auth::user()->bidang_id;
        }else{
            $bidang_id = $request->bidang_id;
        }
        $user->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'bidang_id' => $bidang_id

        ]);
        $user->syncRoles($request->roles);
        return redirect()->route('backend.users.index')->with('success', 'Pengguna berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Storage::disk('uploads')->exists($user->image)) {
            Storage::disk('uploads')->delete($user->image);
        }
        $user->delete();
        return redirect()->route('backend.users.index')->with('success', 'Pengguna berhasil dihapus');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('backend.users.index')->with('success', 'Reset password user berhasil');
    }
}
