<?php

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        Role::create($validated);

        return redirect()->route('admin.permissions_roles.index');
    }

    public function destroy(Role $role)
    {

        $role->delete();

        return redirect()->route('admin.permissions_roles.index');
    }
}
