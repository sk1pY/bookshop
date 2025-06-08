<?php

namespace App\Http\Controllers;

use App\Models\BasketItem;
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

        $bookQuery = Book::where('category_id', $category->id);

//        $bookQuery = Auth::check() ?
//            Book::where('category_id', $category->id) :
//            Book::whereIn('id', $bookIds);

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
