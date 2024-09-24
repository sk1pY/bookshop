<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketItemController extends Controller
{
    public function index()
    {

        $basket = Basket::where(['user_id' => Auth::id()])->first();
        if ($basket) {
            $booksInBasket = BasketItem::where(['basket_id' => $basket->id])->get();
            $total_price = $basket->price;
        } else {
            $booksInBasket = null;
            $total_price = 0;
        }

        return view('basket', compact('booksInBasket', 'total_price'));
    }

    public function addToBasket(Request $request, $id)
    {
        $basketUser = Basket::firstOrCreate(['user_id' => Auth::id()]);
        $bookInBasket = BasketItem::where(['book_id' => $id, 'basket_id' => $basketUser->id])->first();

        if (!$bookInBasket) {
            $bookInBasket = BasketItem::create(['book_id' => request('book_id'), 'basket_id' => $basketUser->id]);
        }

        $bookInBasket->increment('quantity');
        $basketUser->price += $bookInBasket->book->price;
        $basketUser->save();


        return redirect()->route('books.index')->with('success', 'Книга успешно добавлена в корзину');

    }

    public function delete($id)
    {
        $basketUser = Basket::where(['user_id' => Auth::id()])->first();
        $bookInBasket = BasketItem::where('book_id', $id)->first();
        if ($bookInBasket->quantity == 1) {
            $bookInBasket->delete();
            if (BasketItem::where('basket_id', $basketUser->id)->count() == 0) {
                $basketUser->delete();
            }
            return redirect()->route('basket.index');

        }

        $bookInBasket->decrement('quantity');
        $basketUser->price -= $bookInBasket->book->price;
        $basketUser->save();


        return redirect()->route('basket.index');
    }

    public function orderAdd(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string',
            'surname' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        Auth::user()->update([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ]);
        $OrderUser = Order::Create(['user_id' => Auth::id(), 'price' => Auth::user()->basket->price, 'status' => 'Новый заказ']);
        $basketJson = $request->input('basket');
        $baskets = json_decode($basketJson);

        //КОЛЛЕКЦИЯ КНИГ КОТОРЫЕ ЗАКАЗАЛ ЮЗЕР
        $bask = collect($baskets);

        foreach ($bask as $basket_item) {
            OrderItem::create([
                'book_id' => $basket_item->book_id,
                'quantity' => $basket_item->quantity,
                'order_id' => $OrderUser->id,
            ]);
        }
            $booksStockUpdate =  OrderItem::where(['order_id' => $OrderUser->id])->get();
            $booksStockUpdate->each(function ($item) {
                $book = Book::where(['id' => $item->book_id])->first();
                $book->stock -= $item->quantity;
                $book->save();
            });

        BasketItem::where('basket_id', Auth::user()->basket->id)->delete();
        Auth::user()->basket->delete();
        return redirect()->route('basket.index');
    }
}
