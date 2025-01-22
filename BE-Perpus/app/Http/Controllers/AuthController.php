<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = Role::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        $token = JWTAuth::fromUser($user);

        $user->load('role');

        return response()->json([
            'message' => 'Register Berhasil',
            'data'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'User Invalid'], 401);
        }

        $user = User::where('email', $request['email'])->with('role')->first();

        $token = JWTAuth::fromUser($user);

        $user->load('role');

        return response()->json([
            'token'   => $token,
            'data'    => $user,
        ], 200);
    }

    public function getUser()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $currentUser = User::with(['role', 'profile'])->find($user->id);

        return response()->json([
            "message" => "Get User Berhasil",
            "data" => $currentUser
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logout Berhasil']);
    }
}
