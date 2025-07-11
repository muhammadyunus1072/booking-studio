<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Account\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('app.auth.login');
    }

    public function login()
    {
        return view('app.auth.login');
    }

    public function register()
    {
        return view('app.auth.register');
    }

    public function forgotPassword()
    {
        return view('app.auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        return view('app.auth.reset-password', ['token' => $request->token, 'email' => $request->email]);
    }

    public function emailVerification(Request $request)
    {
        return view('app.auth.email-verification', ['email' => $request->email]);
    }

    public function profile()
    {
        return view('app.auth.profile');
    }

    public function emailVerificationVerify(Request $request)
    {
        $user = UserRepository::find($request->id);
        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $request->hash)) {
            return redirect()->route('login');
        }

        $user->email_verified_at = Carbon::now();
        $user->save();

        Auth::loginUsingId($user->id);

        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }

    // API
    // App\Http\Controllers\AuthController.php
    public function register_api(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'password' => 'required|min:6',
        ]);
        $user = UserRepository::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => $user,
        ], 201);
    }
}
