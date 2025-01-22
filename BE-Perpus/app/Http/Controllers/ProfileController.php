<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'age' => 'required|integer',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $currentUser = auth()->user();

        $profileData = Profile::updateOrCreate(
            ['user_id' => $currentUser->id],
            [
                'age' => $request->age,
                'bio' => $request->bio,
                'user_id' => $currentUser->id,
            ]
        );

        return response()->json([
            'message' => 'Profile berhasil diubah',
            'data'    => $profileData,
        ], 201);
    }

    public function index()
    {
        $currentUser = auth()->user();

        $user = Profile::with('user')->where('user_id', $currentUser->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Simpan profile berhasil',
            'data'    => $user,
        ], 201);
    }
}
