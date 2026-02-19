<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\DeliveryBoy;
use App\Models\Location;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sub_admin = User::where('status', 'active')->where('role_name', 'sub_admin')->count();
        $product = Products::count();
        $delivery_boys = DeliveryBoy::where('status', '1')->count();
        $location= Location::count();

        return view('.dashboard.home', compact('product', 'sub_admin', 'delivery_boys', 'location'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function profile_update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'mobile' => 'required|unique:user,mobile,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();


        return redirect()->back()->with('success', 'User Profile updated successfully');
    }
    public function profile_image_update(Request $request)
{
    $request->validate([
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp'
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_image')) {

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $imagePath = $request->file('profile_image')->store('users', 'public');


        $user->avatar = $imagePath;
        $user->save();
    }

    return back()->with('success', 'Profile image updated successfully');
}
// test 
}
