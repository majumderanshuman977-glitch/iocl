<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

public function index(){
    $permissions = Permission::orderBy('id', 'desc')->get();
    $roles = Role::orderBy('id', 'desc')->get();


    return view('dashboard.roles.index', compact('permissions','roles'));
}

public function create(Request $request){
   return view('dashboard.roles.create');

}

public function store(Request $request){
    $request->validate([
        'role_name' => 'required|string|unique:roles,name',
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id',
    ]);


    $role = Role::create(['name' => $request->role_name]);
    if(empty($request->permissions)){
        
    }
     foreach ($request->permissions as $permissionId) {
        $permission = Permission::findById($permissionId);
        $role->givePermissionTo($permission);
    }
    return redirect()->route('roles.list')->with('success', 'Role created successfully.');

}

public function show($id){

}

public function edit($id){
    return view('dashboard.roles.edit');

}

public function update(Request $request, $id){
    $request->validate([
        'role_name' => 'required|string|unique:roles,name,'.$id,
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    $role = Role::findOrFail($id);
    $role->update(['name' => $request->role_name]);

   foreach ($request->permissions as $permissionId) {
        $permission = Permission::findById($permissionId);
        if (!$role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }

     $currentPermissions = $role->permissions()->pluck('id')->toArray();
    foreach ($currentPermissions as $permissionId) {
        if (!in_array($permissionId, $request->permissions)) {
            $permission = Permission::findById($permissionId);
            $role->revokePermissionTo($permission);
        }
    }

    return redirect()->route('roles.list')->with('success', 'Role updated successfully.');

}

public function destroy($id)
{

    $role = Role::find($id);

    if (!$role) {
        return response()->json([
            'status' => false,
            'message' => 'Role not found'
        ], 404);
    }

    $role->delete();

    return response()->json([
        'status' => true,
        'message' => 'Role deleted successfully'
    ]);
}


}
