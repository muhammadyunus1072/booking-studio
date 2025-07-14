<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FilePathHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Account\UserRepository;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function get_users(Request $request)
    {
        // $page = $request->page ?? null;
        $users = UserRepository::datatable('Seluruh')->orderBy('id', 'DESC')->paginate(10);
        $users->getCollection()->transform(function ($user) {
            $user->first_name = "first $user->name";
            $user->last_name = "last $user->name";
            $user->avatar = 'https://reqres.in/img/faces/' . rand(1, 10) . '-image.jpg';
            return $user;
        });

        return response()->json([
            'success' => true,
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'total' => $users->total(),
            'data' => $users->items(),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('photo')->store(FilePathHelper::FILE_API_UPLOAD_PHOTO, 'public');

        $user = $request->user();
        logger($user);
        $user->photo = $path;
        $user->save();

        return response()->json([
            'message' => 'Upload berhasil',
            'photo_url' => asset('storage/' . $path),
        ]);
    }

    // API
    // App\Http\Controllers\AuthController.php
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'password' => 'required|min:6',
        ]);
        $user = UserRepository::create([
            'username' => $validated['username'],
            'name' => $validated['username'],
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
