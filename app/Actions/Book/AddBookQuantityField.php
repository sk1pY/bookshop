<?php

namespace App\Actions\Book;

use App\Models\Basket;
use Illuminate\Support\Facades\Auth;

Class AddBookQuantityField {

    public function execute($basket  ,$books)
    {
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

        return $books;
    }
}
