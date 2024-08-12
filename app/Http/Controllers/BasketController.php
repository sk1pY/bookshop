<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Book;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function index()
    {
        $baskets = Book::withCount('baskets')
            ->having('baskets_count', '>', 0)
            ->get();

        $sum = Basket::with('book')
            ->get()
            ->sum(function ($basketItem) {
                return $basketItem->book->price;
            });

        return view('basket',compact('baskets','sum'));
    }

    public function add(Request $request){
            $basket = new Basket();
            $basket->book_id = $request->input('book_id');
            $basket->save();
            return redirect()->route('books.index')->with('success', 'Книга добавлена в корзину!');

    }

    public  function delete($id){

        $basketItem = Basket::where('book_id', $id)->first();

        $basketItem->delete();
        return redirect()->route('basket.index')->with('success', 'Book successfully deleted!');
    }

}
