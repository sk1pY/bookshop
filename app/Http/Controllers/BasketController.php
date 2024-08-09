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
        $price = Book::sum('price');

        return view('basket',compact('baskets'));
    }

    public function add(Request $request){
            $basket = new Basket();
            $basket->book_id = $request->input('book_id');
            $basket->save();
            return redirect()->route('basket.index')->with('success', 'Item successfully added to basket!');
//        }
//        return redirect()->route('books.index')->with('error', 'An error occurred while processing your request.');

    }

    public  function delete($id){

        $basketItem = Basket::where('book_id', $id)->first();

        $basketItem->delete();
        return redirect()->route('basket.index')->with('success', 'Book successfully deleted!');
    }

}
