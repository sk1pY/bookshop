<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required|min:0',
            'stock' => 'numeric|required|min:0',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            return response()->json(['errors' => $errors->all()], 422);

        }
        Book::create($validated);

        return response()->json('Book added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'book not found'], 404);

        }
        return $book;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Book $book)
    {
        $validated = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required|min:0',
            'stock' => 'numeric|required|min:0',
        ]);

        $book->update($validated);
        return response()->json('Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json('Book deleted successfully');
    }

    public function stock(Book $book)
    {
        return $book->stock;
    }

    public function commentaries(Book $book)
    {
        if ($book->commentaries->isEmpty()) {
            return response()->json(['message' => 'There are no comments yet'], 404);
        }
        return $book->commentaries()->get();
    }
}
