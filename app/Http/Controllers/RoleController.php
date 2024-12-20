<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
   

    public function store(Request $request){
        Role::create([
            'name' => $request['role'],
        ]);

         return redirect()->route('admin.permissions_roles.index');
    }

    public function destroy(Request $request, Role $role){

        $role -> delete();

         return redirect()->route('admin.permissions_roles.index');
    }
}
