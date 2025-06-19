<?php

namespace App\Http\Controllers;

use App\Actions\Book\AddBookQuantityField;
use App\Actions\Book\FilterBooks;
use App\Models\Author;
use App\Models\Bookmark;
use App\Services\BasketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function __invoke(
        Request              $request,
        Author               $author,
        AddBookQuantityField $addBookQuantityField,
        BasketService        $basketService,
        FilterBooks          $filterBooks): View
    {
        $basket = $basketService->getBasket();

        $booksQuery = $filterBooks->execute($author->books(), $request->input('filter'));
        $books = $booksQuery->paginate(10);

        $addBookQuantityField->execute($basket, $books);

        return view('front.author', compact('books', 'author'));
    }
}
