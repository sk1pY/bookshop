<?php

namespace App\Http\Controllers;

use App\Actions\Book\AddBookQuantityField;
use App\Actions\Book\FilterBooks;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use App\Services\BasketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function specialCategories(
        Request              $request, $slug,
        FilterBooks          $filterBooks,
        AddBookQuantityField $addBookQuantityField,
        BasketService        $basketService): View
    {
        $basket = $basketService->getBasket();
        $booksQuery = Book::query();
        $filter = $request->input('filter');
        $filterBooks->execute($booksQuery, $filter);

        $booksQuery = match ($slug) {
            'bestsellers' => $booksQuery->bestsellers(),
            'newest' => $booksQuery->newest(),
            'sales' => $booksQuery->sales(),
            default => $booksQuery
        };

        $books = $booksQuery->paginate(10);

        $addBookQuantityField->execute($basket, $books);

        $cat_rus = match ($slug) {
            'bestsellers' => 'Бестселлеры',
            'newest' => 'Новинки',
            'sales' => 'Акции',
            default => 'Неизвестно',
        };


        return view('front.categories.special_categories_show', compact('books', 'slug', 'cat_rus'));
    }

    public function show(
        Request              $request,
        Category             $category,
        FilterBooks          $filterBooks,
        AddBookQuantityField $addBookQuantityField,
        BasketService        $basketService): View
    {
        $basket = $basketService->getBasket();
        $bookmarkTaskUser = Auth::check() ?
            Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray() : null;

        $booksQuery = $category->books();
        $filter = $request->input('filter');
        $filterBooks->execute($booksQuery, $filter);

        $books = $booksQuery->paginate(10);

        $addBookQuantityField->execute($basket, $books);

        return view('front.categories.categories', compact('books', 'category', 'bookmarkTaskUser'));
    }


}
