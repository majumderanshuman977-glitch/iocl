<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users'; // Specify the table name if it's not pluralized

    protected $fillable = [
        'last_login',
        'avatar' // Ensure this is included
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** generate id */
    // protected static function boot()
    // {
    //     parent::boot();

    //     self::creating(function ($model) {
    //         $latestUser = self::orderBy('user_id', 'desc')->first();
    //         $nextID = $latestUser ? intval(substr($latestUser->user_id, 3)) + 1 : 1;
    //         $model->user_id = 'KH-' . sprintf("%04d", $nextID);

    //         // Ensure the user_id is unique
    //         while (self::where('user_id', $model->user_id)->exists()) {
    //             $nextID++;
    //             $model->user_id = 'KH-' . sprintf("%04d", $nextID);
    //         }
    //     });
    // }

    /** Insert New Users */
    public function saveNewuser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'nullable|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'mobile'  => 'nullable|string|max:20|unique:users,mobile',
        ], [
            'email.unique' => 'This email is already registered. Please use another.',
            'mobile.unique' => 'This mobile number is already registered. Please use another.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Please fix the errors below.');
        }

        try {
            $save             = new User;
            $save->name       = $request->name;
            $save->avatar     = $request->image;
            $save->email      = $request->email;
            $save->role_name  = 'super_admin';
            $save->status     = 'active';
            $save->password   = Hash::make($request->password);
            $save->mobile     = $request->mobile;
            $save->save();
            return redirect('login')->with('success', 'Account created successfully :)');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Failed to Create Account. Please try again.');
        }
    }
}
