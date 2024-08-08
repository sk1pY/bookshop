<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $categories = Category::all();
        $books = Book::all();
        $bookInBasket = Basket::all()->count();
        return view('index',compact('books','categories','bookInBasket'));
    }

    public function author($id){
      $booksOfAuthor = Book::where('author_id',$id)->get();
      return view('author',compact('booksOfAuthor'));
    }
    public function book($id){
        $book = Book::find($id);
        return view('book',compact('book'));
    }

    public function categoryBooks($id)
    {
        $categoryBooks = Book::where('category_id',$id)->get();
        return view('categoryBooks',compact('categoryBooks'));
    }

}
