<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::latest()->get();

        return response()->json([
            'message' => 'data berhasil ditampilkan',
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->error(), 422);
        }

        $data = Role::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'data berhasil ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Role::with('users')->find($id);

        if(!$data) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'detail data berhasil ditampilkan',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Role::find($id);

        if(!$data) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $data->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'data berhasil diupdate',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Role::find($id);

        if(!$data) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'message' => 'data berhasil dihapus',
        ]);
    }
}
