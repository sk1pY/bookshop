<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function specialCategories(Request $request, $slug): View
    {
        $bookQuery = Book::query();
        $bookQuery = match ($slug) {
            'bestsellers' => $bookQuery->bestsellers(),
            'newest' => $bookQuery->newest(),
            'sales' => $bookQuery->sales(),
            default => null
        };

        $bookQuery = match ($request->input('filter')) {
            'cheap' => $bookQuery->orderBy('price'),
            'expensive' => $bookQuery->orderBy('price', 'desc'),
            'rating' => $bookQuery->orderBy('avgRating', 'desc'),
            default => $bookQuery->latest()
        };


        $basket = app('basket');
        $books = $bookQuery->paginate(10);

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

        $cat_rus = match ($slug) {
            'bestsellers' => 'Бестселлеры',
            'newest' => 'Новинки',
            'sales' => 'Акции',
            default => 'Неизвестно',
        };


        return view('front.categories.special_categories_show', compact('books', 'slug', 'cat_rus'));
    }

    public function show(Request $request, Category $category)
    {
        $bookmarkTaskUser = Auth::check() ?
            Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray() : null;

        $bookQuery = $category->books();

        $bookQuery = match ($request->input('filter')) {
            'cheap' => $bookQuery->orderBy('price'),
            'expensive' => $bookQuery->orderBy('price', 'desc'),
            'rating' => $bookQuery->orderBy('avgRating', 'desc'),
            default => $bookQuery->latest()
        };


        $basket = app('basket');
        $books = $bookQuery->paginate(10);

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


        return view('front.categories.categories', compact('books', 'category', 'bookmarkTaskUser'));
    }


}
