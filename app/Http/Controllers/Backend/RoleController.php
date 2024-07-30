<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Role\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {
        $role = new Role();
        $permission = Permission::all();
        $permissionselected = [];
        return view('backend.role.create', compact(['role','permission','permissionselected']));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->givePermissionTo($request->permissions);
        return redirect()->route('backend.roles.index')->with('success', 'Role berhasil disimpan');
    }

    public function edit(Role $role)
    {
        $permission = Permission::all();
        $permissionselected = [];
        foreach (json_decode($role->permissions) as $key => $value) {
            $permissionselected[$key] = $value->name;
        }
        return view('backend.role.edit', compact(['role', 'permission','permissionselected']));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = Role::find($role->id);
        $role->update($request->all());
        $role->revokePermissionTo($role->permissions);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('backend.roles.index')->with('success', 'Role berhasil diubah');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('backend.roles.index')->with('success', 'Role berhasil dihapus');
    }
}
