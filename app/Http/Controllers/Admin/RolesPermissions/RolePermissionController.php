<?php

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function updatePermissionsForRole(Request $request, Role $role)
    {
        if (!$request->input('permissions')) {
            $role->permissions()->detach();
            return redirect()->route('admin.permissions_roles.index')->with('success', 'Deleted');
        }
        $permissionName = Permission::whereIn('id', $request->input('permissions'))->pluck('name')->toArray();
        $role->syncPermissions($permissionName);

        return response()->json(['success'=>'success update']);
    }

    public function updateRoleForUser(Request $request, User $user)
    {
        $role = $request['role'];
        $user->syncRoles($role);
        return response()->json(['success' => 'User role updated successfully.','role' => $role]);


    }
}
