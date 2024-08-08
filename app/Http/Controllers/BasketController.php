<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Book;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function index()
    {
        $baskets = Basket::get();



        return view('basket',compact('baskets'));
    }

    public function add(Request $request){
        $basket = new Basket();
        $bookID = $request->input('book_id');
        $basketItem = Basket::where('book_id', $bookID)->first();
        if($basketItem == null){
            $basket->book_id = $request->input('book_id');
            $basket->save();
            return redirect()->route('books.index')->with('success', 'Item successfully added to basket!');

        }
        return redirect()->route('books.index')->with('error', 'An error occurred while processing your request.');

    }

    public  function delete($id){

        $basketItem = Basket::where('book_id', $id)->first();
       // dd($basketItem);
        $basketItem->delete();
        return redirect()->route('books.index')->with('success', 'Book successfully deleted!');
    }

}
