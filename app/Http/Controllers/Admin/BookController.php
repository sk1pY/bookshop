<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->orderBy('created_at', 'desc')->paginate(10);
        $authors = Author::get();

        return view('admin.books.index', compact('books','authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::get();
        $categories = Category::get();

        return view('admin.books.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric'
        ]);

        if ($request->hasFile('file')) {
            $validated['image'] = basename($request->file('file')->store('booksImages', 'public'));
        }
        if( Book::create($validated)){
            return redirect()->route('admin.books.index')->with('success', 'book added success');

        }
        return to_route('admin.books.index')->with('info','book added error');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'author_id' => 'sometimes|nullable|numeric|exists:authors,id'

        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = basename($request->file('image')->store('booksImages', 'public'));
        }

        if ($book->update($validated)) {
            return to_route('admin.books.index')->with('success', 'book update success');
        }
        return to_route('admin.books.index')->with('info','book update error');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return to_route('admin.books.index');
    }
}
