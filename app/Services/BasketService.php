<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BasketService
{
    protected $basket;

    public function __construct()
    {
        $this->basket = app('basket');
    }

    public function booksInBasket(): Collection
    {

        return Auth::check() ?
            $this->getBooksAuth() :
            $this->getBooksGuest();

    }

    public function getBasket()
    {
            return $this->basket;
    }

    public function basketFullPrice()
    {
        return $this->booksInBasket()->sum(fn($item) => $item->quantity * $item->price);
    }

    protected function getBooksGuest(): Collection
    {
        return collect(session()->get('books', collect()));
    }

    protected function getBooksAuth(): Collection
    {
        return $this->basket->basket_items()
            ->with('book')
            ->get()
            ->map(function ($item) {
                $book = $item->book;
                $book->quantity = $item->quantity;
                $book->fullPrice = $book->quantity * $book->price;
                return $book;
            });
    }

}
