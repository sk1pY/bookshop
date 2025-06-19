<?php


namespace App\Actions\Book;

use App\Models\Basket;
use App\Models\BasketItem;
use Illuminate\Support\Facades\Auth;

class MergeAuthSessionBooksAction
{
    public function execute($basket, $books)
    {
        $books_session = collect(session('books', []));
        $books_session->each(function ($book) use ($basket) {
            $basketitem = BasketItem::firstOrCreate([
                'book_id' => $book->id,
                'basket_id' => $basket->id],
                ['quantity' => 0]);
            if ($basketitem->quantity < $basketitem->book->stock) {
                $basketitem->update([
                    'quantity' => $basketitem->quantity + $book->quantity,
                ]);
                $basketitem->save();
            }

            session()->forget('books');

        });

        return $books;
    }
}
