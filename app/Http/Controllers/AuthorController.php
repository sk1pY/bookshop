<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index(Author $author)
    {
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
        $books =  $author->books()->get();
        return view('author', compact('books', 'bookmarkTaskUser', 'author'));
    }
}
