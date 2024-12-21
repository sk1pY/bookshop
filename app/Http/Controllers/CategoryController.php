<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function category_bestsellers()
    {
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $books = \App\Models\Book::orderBy('numberOfPurchased', 'desc')->get();
        return view('bestsellers', compact('books', 'bookmarkTaskUser'));
    }

    public function category_newest()
    {
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $books = \App\Models\Book::orderBy('created_at', 'asc')->get();
        return view('newest', compact('books', 'bookmarkTaskUser'));
    }

    public function category_sale()
    {
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();

        $books = \App\Models\Book::where('discount', '>', 0)->get();
        // dd($books);
        return view('sale', compact('books', 'bookmarkTaskUser'));
    }
}
