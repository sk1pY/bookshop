<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $books = Book::with('author')->orderBy('created_at', 'desc')->paginate(10);
        $authors = Author::get();

        return view('admin.books.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $authors = Author::get();
        $categories = Category::get();

        return view('admin.books.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            $validated['image'] = basename($request->file('file')->store('booksImages', 'public'));
        } else {
            $localPath = public_path('defaultImages/defaultImage.jpg');
            $validated['image'] = basename(Storage::disk('public')->putFile('booksImages', $localPath));
        }
        Book::create($validated);
        return back()->with('success', 'book added success');

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
    public function update(UpdateBookRequest $request, Book $book):RedirectResponse
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('booksImages/' . $book->image);
            $validated['image'] = basename($request->file('image')->store('booksImages', 'public'));
        }
        $book->update($validated);
        return back()->with('success', 'book update success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book):RedirectResponse
    {
        $book->delete();
        return back()->with('success', 'book deleted success');
    }
}
