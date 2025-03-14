<?php

namespace App\Http\Controllers\Admin\RolesPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function store(Request $request){
        Role::create([
            'name' => $request['role'],
        ]);

         return redirect()->route('admin.permissions_roles.index');
    }

    public function destroy(Role $role){

        $role -> delete();

         return redirect()->route('admin.permissions_roles.index');
    }
}
