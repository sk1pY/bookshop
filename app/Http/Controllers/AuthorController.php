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
        $basket = app('basket');

        $quantities = $basket->basket_items()->pluck('quantity', 'book_id');
        $books->each(function ($book) use ($quantities) {
            $book->quantity = $quantities[$book->id] ?? 0;
        });
        return view('front.author', compact('books', 'bookmarkTaskUser', 'author'));
    }
}
