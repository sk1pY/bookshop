<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index($id)
    {
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
        $books = Book::where('author_id', $id)->get();
        $author = Author::find($id);
        return view('author', compact('books','bookmarkTaskUser','author'));
    }
}
