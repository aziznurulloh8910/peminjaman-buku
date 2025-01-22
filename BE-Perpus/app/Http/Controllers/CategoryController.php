<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:api','isAdmin'])->only(['store','update','destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::latest()->get();

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
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'data berhasil ditambahkan',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::with('books')->find($id);

        if (!$data) {
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
        $data = Category::find($id);

        if (!$data) {
            return response()->json([
                'message' => 'data tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'data berhasil diupdate',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Category::find($id);

        if (!$data) {
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
