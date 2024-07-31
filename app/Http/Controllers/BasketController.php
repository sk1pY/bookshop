<?php

namespace App\Http\Controllers;

use App\Models\Basket;
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
        $basket->book_id = $request->input('book_id');
        $basket->save();
        return view('index');
    }
}
