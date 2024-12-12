<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
{
    public function categoryBooks(Request $request, Category $category)
    {
        $categories = Category::all();
        $bookmarkTaskUser = null;
        if (Auth::guard()->check()) {
            $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
        }

        $booksQuery = $category->books();

        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $booksQuery->orderBy('price', 'asc');
                    break;
                case 'expensive':
                    $booksQuery->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $booksQuery->orderBy('avgRating', 'desc');
                    break;
                default:
                    break;
            }
        }

        $books = $booksQuery->get();




        return view('categoryBooks', compact('books', 'category', 'bookmarkTaskUser'));
    }
}
