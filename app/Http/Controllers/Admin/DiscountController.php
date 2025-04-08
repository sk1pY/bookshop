<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    public function index()
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->paginate(10);
        $books = Book::get();
        $authors = Author::get();

        return view('admin.discount', compact('authors', 'booksWithDiscount', 'books'));
    }

    public function discountForAuthor(Request $request)
    {
        $validated = $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);
        $authorBooks = Book::get();
        if (request('author_id')) {
            $author = Author::find(request('author_id'));
            $authorBooks = $author->books()->get();
        }

        $discount = $validated['discount'];
        $authorBooks->each(function ($book) use ($discount) {
            $book->price = $book->price - round($book->price * $discount * 0.01, 2);
            $book->discount = $discount;
            $book->save();
        });
        return to_route('admin.discounts.index');
    }

    public function discountForBook(Request $request)
    {
        $validate = $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $books = Book::get();
        $discount = $validate['discount'];

        if (request('book_id')) {
            $book = Book::find(request('book_id'));
            $book->price = $book->price - round($book->price * $discount * 0.01, 2);
            $book->discount = $discount;
            $book->save();
        } else {
            $books->each(function ($book) use ($discount) {
                $book->price = $book->price - round($book->price * $discount * 0.01, 2);
                $book->discount = $discount;
                $book->save();
            });
        }
        return to_route('admin.discounts.index');
    }


    public function destroy(Book $book)
    {
        $book->price = round($book->price / ((100 - $book->discount) * 0.01), 2);
        $book->discount = 0;
        $book->save();
        return to_route('admin.discounts.index');
    }

    public function discountDeleteAll()
    {
        $books = Book::where('discount', '>', 0)->get();
        $books->each(function ($book) {
            $book->price = round($book->price / ((100 - $book->discount) * 0.01), 2);
            $book->discount = 0;
            $book->save();
        });
        return to_route('admin.discounts.index');
    }
}
