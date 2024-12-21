<?php

namespace App\Http\Controllers\RolesPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{


    public function store(Request $request){
        Permission::create([
            'name' => $request['permission'],
        ]);

        return redirect()->route('admin.permissions_roles.index');
    }

    public function destroy(Request $request, Permission $permission){

        $permission -> delete();

        return redirect()->route('admin.permissions_roles.index');
    }
}
