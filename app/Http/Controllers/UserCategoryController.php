<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
{
    public function categoryBooks(Category $category)
    {
        $categories = Category::all();
        $bookmarkTaskUser = null;
       if( Auth::guard()->check()){
           $bookmarkTaskUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
       }
        $books = $category->books()->get();

        return view('categoryBooks', compact( 'books', 'category', 'bookmarkTaskUser'));
    }
}
