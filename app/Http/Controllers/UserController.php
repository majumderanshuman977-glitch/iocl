<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_users')->only(['superAdmin', 'subAdmin']);

        $this->middleware('permission:create_users')
            ->only(['createSuperAdmin', 'createSubAdmin', 'store']);

        $this->middleware('permission:edit_users')
            ->only(['editSuperAdmin', 'editSubAdmin', 'update']);
    }

    public function list()
    {
        $user = User::orderBy('id', 'desc')->get();
        return view('user.list', compact('user'));
    }



    public function superAdmin(Request $request)
    {
        $query = User::role('super_admin')->orderBy('id', 'desc');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('mobile', 'like', '%' . $request->name . '%')
                ->orWhere('email', 'like', '%' . $request->name . '%');
        }



        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $user = $query->paginate(10)->withQueryString();

        return view('user.superadmin', compact('user'));
    }


    public function subAdmin(Request $request)
    {
        $query = User::role('sub_admin')->orderBy('id', 'desc');


        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('mobile', 'like', '%' . $request->name . '%')
                ->orWhere('email', 'like', '%' . $request->name . '%');
        }



        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }


        $user = $query->paginate(10)->withQueryString();

        return view('user.subadmin', compact('user'));
    }

    public function createSuperAdmin()
    {
        return view('user.superadmin_create');
    }

    public function createSubAdmin()
    {

        return view('user.subadmin_create');
    }

    public function editSuperAdmin($id)
    {
        $user = User::find($id);
        return view('user.superadmin_edit', compact('user'));
    }

    public function editSubAdmin($id)
    {
        $user = User::find($id);
        return view('user.subadmin_edit', compact('user'));
    }

    public function new()
    {
        $role = Role::all();
        return view('user.new', compact('role'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:10|unique:users,mobile',
            'email' => 'nullable|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('users', 'public');
        }

        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->avatar = $imagePath;
        $user->status = 'active';
        $user->role_name = $request->roles[0];
        $user->save();


        $user->assignRole($request->roles);


        $allPermissions = Permission::pluck('name')->toArray();




        if ($request->roles[0] === 'super_admin') {
            $user->syncPermissions($allPermissions);
            return redirect()
                ->route('user.superadmin')
                ->with('success', 'Super Admin created');
        } else {
            $user->syncPermissions(['view_users', 'create_users', 'view_location', 'create_delivery_boys', 'view_delivery_boys']);
            return redirect()
                ->route('user.subadmin')
                ->with('success', 'Sub Admin created');
        }
    }




    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();

        return view('user.edit', compact('user', 'role'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:10|unique:users,mobile,' . $id,
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $imagePath = $user->avatar;

        if ($request->hasFile('profile_image')) {

            if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                unlink(public_path('storage/' . $user->avatar));
            }

            $imagePath = $request->file('profile_image')->store('users', 'public');
            $user->avatar = $imagePath;
        }

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->syncRoles($request->roles);

        if ($request->roles[0] == 'super_admin') {
            return redirect()->route('user.superadmin')->with('success', 'Super Admin updated');
        } elseif ($request->roles[0] == 'sub_admin') {
            return redirect()->route('user.subadmin')->with('success', 'Sub Admin updated');
        }
    }

    public function permissionsSubAdmin($id)
    {
        $user = User::findOrFail($id);

        $permissions = Permission::all();


        $userPermissions = $user->getPermissionNames()->toArray();

        return view('user.permissions', compact('permissions', 'user', 'userPermissions'));
    }


    public function permissionsSuperAdmin($id)
    {
        $user = User::findOrFail($id);

        $permissions = Permission::all();
        $userPermissions = $user->getPermissionNames()->toArray();

        return view('user.permissions', compact('permissions', 'user', 'userPermissions'));
    }

    public function assignPermissions(Request $request)
    {

        $user = User::findOrFail($request->user_id);

        $permissions = $request->permissions ?? [];

        $user->syncPermissions($permissions);

        if ($user->hasRole('sub_admin')) {

            return redirect()->route('user.subadmin')->with('success', 'Permissions updated');
        } else {
            return redirect()->route('user.superadmin')->with('success', 'Permissions updated');
        }
    }

    public function updateStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
            unlink(public_path('storage/' . $user->avatar));
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
