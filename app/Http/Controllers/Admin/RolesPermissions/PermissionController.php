<?php

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);
        Permission::create($validated);

        return redirect()->back();
    }

    public function destroy( Permission $permission){

        $permission -> delete();

        return redirect()->route('admin.permissions_roles.index');
    }
}
