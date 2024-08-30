<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketItemsController extends Controller
{
    public function index()
    {
        $basket = Basket::where(['user_id' => Auth::id()])->first();
        if($basket){
            $booksInBasket = Basket_items::where(['basket_id' => $basket->id])->get();
            $total_price = $basket->price;
        }else {
            $booksInBasket = null;
            $total_price = 0;
        }

        return view('basket', compact('booksInBasket', 'total_price'));
    }

    public function addToBasket(Request $request, $id)
    {
        $basketUser = Basket::firstOrCreate(['user_id' => Auth::id()]);
        $bookInBasket = Basket_items::where(['book_id' => $id, 'basket_id' => $basketUser->id])->first();

        if (!$bookInBasket) {
            $bookInBasket = Basket_items::create(['book_id' => request('book_id'), 'basket_id' => $basketUser->id]);
        }

        $bookInBasket->increment('count');
        $basketUser->price += $bookInBasket->book->price;
        $basketUser->save();


        return redirect()->route('basket.index');

    }

    public function delete($id)
    {
        $basketUser = Basket::where(['user_id' => Auth::id()])->first();

        $bookInBasket = Basket_items::where('book_id', $id)->first();
        if ($bookInBasket->count == 1) {
            $bookInBasket->delete();
        }
        $bookInBasket->decrement('count');
        $basketUser->price -= $bookInBasket->book->price * $bookInBasket->count;
        $basketUser->save();


        return redirect()->route('basket.index');
    }

    public function order(Request $request)
    {
        $basketJson = $request->input('basket');
        $baskets = json_decode($basketJson);
        $bask = collect($baskets);
        Order::create(['user_id' => Auth::id(), 'basket_id' => $bask->first()->id]);
    }
}
