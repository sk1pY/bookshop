<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function categoriesTop(Request $request,$type)
    {
        $query = Book::query();
        $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
        if ($type === 'bestsellers') {
            $query->bestsellers();
        } elseif ($type === 'newest') {
            $query->newest();
        } elseif ($type === 'sales') {
            $query->sales();
        }
        $books = Book::filters($request)->get();
        return view($type, compact('books', 'bookmarkTaskUser'));
    }


}
