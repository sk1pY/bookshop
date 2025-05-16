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
        $bookQuery = Book::query();
        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $bookQuery->orderBy('price');
                    break;
                case 'expensive':
                    $bookQuery->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $bookQuery->orderBy('avgRating', 'desc');
            }
        }

        match ($slug) {
            'bestsellers' => $bookQuery->bestsellers(),
            'newest' => $bookQuery->newest(),
            'sales' => $bookQuery->sales(),
            default => null
        };
        $basket = app('basket');

        $quantities = $basket->basket_items()->pluck('quantity', 'book_id');
        $books = $bookQuery->paginate(10);
        $books->getCollection()->each(function ($book) use ($quantities) {
            $book->quantity = $quantities[$book->id] ?? 0;
        });

        return view($slug, compact('books'));
    }

    public function show(Request $request, Category $category)
    {
        $bookmarkTaskUser = Auth::check() ?
            Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray() : null;

        $bookQuery = $category->books();
        if ($request->filled('filter')) {
            switch ($request->input('filter')) {
                case 'cheap':
                    $bookQuery->orderBy('price');
                    break;
                case 'expensive':
                    $bookQuery->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $bookQuery->orderBy('avgRating', 'desc');
            }
        }
        if ($categoryId = $request->input('category_id')) {
            $bookQuery->where('category_id', $categoryId);
        }

        $books = $bookQuery->get();

        return view('categoryBooks', compact('books', 'category', 'bookmarkTaskUser'));
    }


}
