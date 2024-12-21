<?php

namespace App\Http\Controllers\RolesPermissions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        $rolesWithPermissions = Role::with('permissions')->get();


        return view('admin.permissions_roles', compact('roles', 'permissions', 'rolesWithPermissions'));
    }

    public function update(Request $request, Role $role)
    {
        if(!$request->input('permissions')) {
            $role->permissions()->detach();
            return redirect()->route('admin.permissions_roles.index')->with('success', 'Deleted');
        }
        $permissionName = Permission::whereIn('id', $request->input('permissions'))->pluck('name')->toArray();
        $role->syncPermissions($permissionName);

        return redirect()->route('admin.permissions_roles.index')->with('success', 'Role permission added successfully');
    }

    public function role_for_user(Request $request,User $user){

        //dd($request->all());
        $role = Role::where('name',$request->input('role'))->first();


        $user ->syncRoles($role);

        return redirect()->route('admin.users.index');




    }
}
