<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function __invoke(Author $author) : View
    {
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
        $books =  $author->books()->paginate(10);


        $basket = app('basket');

        //ADD QUANTITY BOOK
        $books_session = collect(session('books', []));
        $quantities = Auth::check() ?
            $basket->basket_items()->pluck('quantity', 'book_id') :
            $books_session->pluck('quantity', 'id');


        $books->setCollection(
            $books->getCollection()->map(function ($book) use ($quantities) {
                $book->quantity = $quantities[$book->id] ?? 0;
                return $book;
            })
        );

        return view('front.author', compact('books', 'bookmarkTaskUser', 'author'));
    }
}
