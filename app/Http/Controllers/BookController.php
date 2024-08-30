<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{
    public function index()
    {
        $users = DB::select('select * from books');
        $categories = Category::all();
        $books = Book::all();
        $basket = Basket::where(['user_id' => Auth::id()])->first();

        $bookInBasket = Basket_items::where(['basket_id'=> $basket -> id])->count();
      //  dd($bookInBasket);
        return view('index', compact('books', 'categories', 'bookInBasket'));
    }

    public function author($id){
      $booksOfAuthor = Book::where('author_id',$id)->get();
      return view('author',compact('booksOfAuthor'));
    }
    public function book($id){
        // если в маргрутах указать book и параметрах метода Book $book то это заменяет $book = Book::find($id);
        $book = Book::find($id);
        return view('book',compact('book'));
    }

    public function categoryBooks($id)
    {
        $categories = Category::all();

        $books = Book::where('category_id',$id)->get();
        return view('categoryBooks',compact('books','categories'));
    }

}
