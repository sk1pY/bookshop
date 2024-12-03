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
        $authors = Author::all();
        $books = Book::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.books.index', compact('books', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();

        return view('admin.books.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required|min:0',
            'stock' => 'numeric|required|min:0',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('booksImages', 'public');
            $fileName = basename($path);
        }

        $authorId = optional(Author::where('surname', $request->input('author'))->first())->id;
        $categoryId = optional(Category::where('name', $request->input('category'))->first())->id;
        $book = Book::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'author_id' => null,
            'category_id' => $categoryId,
            'image' => $fileName
        ]);

        return redirect()->route('admin.books.index')->with('successBookAdd', 'Книга добавлена');
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
      //  $book = Book::find($id);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'numeric|required|min:0',
            'stock' => 'numeric|required|min:0',
            //'image' => 'image|mimes:jpeg,png,jpg,gif,svg',

        ]);

        $result =   $book->update([
            'title' => $validatedData['title'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
         //   'image' => $validatedData['image'],
            'author_id' => $request->input('author_id'),
        ]);


        return redirect()->route('admin.books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book:: destroy($id);
        return redirect()->route('admin.books.index');
    }
}
