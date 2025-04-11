<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function specialCategories(Request $request, $slug)
    {
        $query = Book::query();
        $bookmarkTaskUser = Auth::check() ?
            Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray() : null;

        match ($slug) {
            'bestsellers' => $query->bestsellers(),
            'newest' => $query->newest(),
            'sales' => $query->sales(),
            default => null
        };

        $books = Book::filters($request)->paginate(10);
        return view($slug, compact('books', 'bookmarkTaskUser'));
    }

    public function show(Request $request, Category $category)
    {
        $bookmarkTaskUser = Auth::check() ?
            Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray() : null;

        $query = $category->books();

        $books = $query->filters($request)->get();
        return view('categoryBooks', compact('books', 'category', 'bookmarkTaskUser'));
    }


}
