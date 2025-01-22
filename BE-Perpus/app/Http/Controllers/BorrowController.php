<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api')->only(['store']);
        $this->middleware(['auth:api', 'isAdmin'])->only(['index']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'load_date' => 'required|date',
            'borrow_date' => 'required|date',
            'book_id' => 'required|uuid|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = auth()->user();
        $borrow = Borrow::updateOrCreate(
            ['user_id' => $user->id, 'book_id' => $request->book_id],
            [
                'load_date' => $request->load_date,
                'borrow_date' => $request->borrow_date,
            ]
        );

        return response()->json([
            'message' => 'Borrow berhasil dibuat/diubah',
            'borrow' => $borrow,
        ], 200);
    }

    public function index()
    {
        $borrows = Borrow::with(['book', 'user'])->get();

        return response()->json([
            'message' => 'Daftar borrow berhasil diambil',
            'borrows' => $borrows,
        ], 200);
    }
}
