<?php

namespace App\Http\Controllers;

use App\Actions\Book\AddBookQuantityField;
use App\Actions\Book\FilterBooks;
use App\Actions\Book\MergeAuthSessionBooksAction;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\InterfaceSite;
use App\Models\OrderItem;
use App\Services\BasketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(
        Request                     $request,
        MergeAuthSessionBooksAction $mergeAuthSessionBooksAction,
        AddBookQuantityField        $addBookQuantityField,
        FilterBooks                 $filterBooks,
        BasketService               $basketService): view
    {

        $slides = InterfaceSite::where('type', 'slide')->get();
        $basket = $basketService->getBasket();
        $booksQuery = Book::query();

        $filter = $request->input('filter');
        $filterBooks->execute($booksQuery, $filter);

        $books = $booksQuery->paginate(15);

        if (Auth::check()) {
            $mergeAuthSessionBooksAction->execute($basket, $books);
        }

        $addBookQuantityField->execute($basket, $books);

        return view('front.index', compact('books', 'slides'));
    }

    public function show(Book $book): View
    {

        if (Auth::check()) {
            $orders = Auth::user()->orders()->where('status', 'Получен')->pluck('id');

            $booksWhichBuyArray = OrderItem::whereIn('order_id', $orders)->pluck('book_id')->toArray();

            in_array($book->id, $booksWhichBuyArray, true) ?
                $bought = true :
                $bought = false;
        }

        $bought = false;
        $bookQuantityInBasket = BasketItem::where('book_id', $book->id)->first()->quantity ?? 0;
        $commentaries = $book->commentaries()->latest()->paginate(6);

        return view('front.book', compact('book', 'commentaries', 'bought', 'bookQuantityInBasket'));
    }


}
