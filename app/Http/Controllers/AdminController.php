<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('created_at','desc')->get();
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.index', compact('books', 'categories', 'authors'));
    }

    public function addBook(Request $request)
    {
         //  dd(Category::where('name', request('category_id'))->first()->id);
        $book = Book::create(['title' => request('title'),
            'price' => request('price'),
            'author_id' => Author::where('name', request('author_id'))->first()->id,
            'category_id' => Category::where('name', request('category_id'))->first()->id
        ]);

        return redirect()->route('admin.index');
    }
    public function deleteBook($id)
    {
       Book:: destroy($id);
        return redirect()->route('admin.index');

    }
    public function updateBook($id,Request $request){
       // dd($id);
        $book = Book::find($id);
        $validatedData = request()->validate([
            'title' => 'required|string|max:255'
        ]);

        $book->update(['title' => $validatedData['title']]);
        return redirect()->route('admin.index');

    }
    public function addCategory(Request $request){
       // dd(request('category_name'));
        Category::create(['name' => request('category_name')]);
        return redirect()->route('admin.index');

    }
}
