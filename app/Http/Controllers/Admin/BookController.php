<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->orderBy('created_at', 'desc')->paginate(10);
        $authors = Author::get();

        return view('admin.books.index', compact('books', 'authors'));
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
            'title' => 'required|string|max:100|unique:books,title',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric'
        ]);

        if ($request->hasFile('file')) {
            $validated['image'] = basename($request->file('file')->store('booksImages', 'public'));
        } else {

            $localPath = public_path('defaultImages/defaultImage.jpg');
            $newPath = Storage::disk('public')->putFile('booksImages', $localPath);
            $validated['image'] = basename($newPath);

        }
        if (Book::create($validated)) {
            return back()->with('success', 'book added success');

        }
        return back()->with('error', 'book added error');
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
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'author_id' => 'nullable|numeric|exists:authors,id'

        ]);
        if ($request->hasFile('image')) {

            if($book->image){
                Storage::disk('public')->delete('booksImages'.$book->image);
            }
            $validated['image'] = basename($request->file('image')->store('booksImages', 'public'));
        } else {
            unset($validated['image']);
        }



        try {
            $book->update($validated);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'book updated error');
        }
        return back()->with('success', 'book update success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'book deleted success');
    }
}
