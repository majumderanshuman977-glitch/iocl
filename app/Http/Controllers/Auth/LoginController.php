<?php

namespace App\Http\Controllers\Auth;

use DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'locked', 'unlock']);
    }

    /** Display the login page */
    public function login()
    {
        return view('auth.login');
    }

    /** Authenticate user and redirect */
    public function authenticate(Request $request)
    {

        $request->validate([
            'mobile'    => 'required|string',
            'password' => 'required|string',
        ]);
        try {
            $credentials = $request->only('mobile', 'password') + ['status' => 'active'];

            if (Auth::attempt($credentials)) {
                // $user = Auth::user();


                // Session::put($this->getUserSessionData($user));

                // Update last login
                // $user->update(['last_login' => Carbon::now()]);
                return redirect()->intended('home')->with('success', 'Login successfully :)');
            }

            return redirect('login')->with('error', 'Wrong Mobile or Password');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()->with('error', 'Login failed. Please try again.');
        }
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('login')->with('success', 'You have been logged out successfully!');
    }
}
