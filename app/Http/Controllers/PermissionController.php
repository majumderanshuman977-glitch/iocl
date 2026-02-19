<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permissions =Permission::all();
      return view('dashboard.permissions.index', compact('permissions'));
    }

    public function create(Request $request){
       return view('dashboard.permissions.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permission.list')->with('success', 'Permission created successfully.');

    }

    public function show($id){

    }

    public function edit($id){
        return view('dashboard.permissions.edit');

    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);

        return redirect()->route('permission.list')->with('success', 'Permission updated successfully.');
    }

   public function destroy($id)
{
    $permission = Permission::findOrFail($id);
    $permission->delete();

    return response()->json([
        'status' => true,
        'message' => 'Permission deleted successfully'
    ]);
}
}
