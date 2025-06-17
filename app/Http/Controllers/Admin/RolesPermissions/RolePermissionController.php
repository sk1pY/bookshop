<?php

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(): View
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $rolesWithPermissions = Role::with('permissions')->get();
        return view('admin.permissions_roles', compact('roles', 'permissions', 'rolesWithPermissions'));
    }

    public function updatePermissionsForRole(Request $request, Role $role): JsonResponse
    {
        $permission = Permission::find($request->input('permissionId'));
        // Log::info($permission);
        $role->hasPermissionTo($permission) ?
            $role->revokePermissionTo($permission) :
            $role->givePermissionTo($permission);
        return response()->json();
    }

    public function updateRoleForUser(Request $request, User $user): JsonResponse
    {
        $role = $request['role'];
        $user->syncRoles([$role]);
        return response()->json(['success' => 'User role updated successfully.', 'role' => $role]);
    }
}
