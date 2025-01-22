<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:api','isAdmin'])->only(['store','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['category'])->get();

        return response()->json([
            'success' => true,
            'message' => 'tampil data berhasil',
            'data'    => $books
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);

            $path = env('APP_URL').'/storage/images/';
            $data['image'] = $path.$imageName;
        }

        $book = Book::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Tambah Book berhasil',
            'data'    => $book
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with(['category'])->find($id);

        if(!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'tampil data berhasil',
            'data'    => $book
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        $data = $request->validated();

        $book = Book::find($id);

        if(!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book tidak ditemukan',
            ], 404);
        }

        if ($request->hasFile('image')) {
            if($book->image) {
                $fileName = basename($book->image);
                Storage::delete('public/images/'. $fileName);
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);

            $path = env('APP_URL').'/storage/images/';
            $data['image'] = $path.$imageName;
        }

        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Update Book berhasil',
            'data'    => $book
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if(!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book tidak ditemukan',
            ], 404);
        }

        if($book->image) {
            $fileName = basename($book->image);
            Storage::delete('public/images/'. $fileName);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hapus Book berhasil',
        ], 200);
    }
}
