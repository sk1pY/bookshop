<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountStoreRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DiscountController extends Controller
{

    public function index(): View
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->paginate(10);
        $books = Book::get();
        $authors = Author::get();

        return view('admin.discount', compact('authors', 'booksWithDiscount', 'books'));
    }

    public function discountForAuthor(DiscountStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $books = Book::get();

        if (request('author_id')) {
            $author = Author::find(request('author_id'));
            $books = $author->books()->get();
        }

        $discount = $validated['discount'];
        $books->each(function ($book) use ($discount) {
            $book->original_price = $book->price;
            $book->price -= round($book->price * $discount * 0.01, 2);
            $book->discount = $discount;
            $book->save();
        });
        return back()->with('success', 'book discount success');
    }

    public function discountForBook(DiscountStoreRequest $request): RedirectResponse
    {
        $validate = $request->validated();

        $books = Book::get();
        $discount = $validate['discount'];

        $applyDiscount = static function ($book) use ($discount) {
            $book->original_price = $book->price;
            $book->price -= round($book->price * $discount * 0.01, 2);
            $book->discount = $discount;
            $book->save();
        };

        if (request('book_id')) {
            $book = Book::find(request('book_id'));
            if ($book) {
                $applyDiscount($book);
            }
        } else {
            $books->each($applyDiscount);
        }
        return back()->with('success', 'book discount success');
    }


    public function destroy(Book $book): RedirectResponse
    {
        $book->update([
            'price' => $book->original_price,
            'discount' => 0
        ]);
        return back()->with('success', 'book discount destroy ');
    }

    public function discountDeleteAll(): RedirectResponse
    {
        Book::where('discount', '>', 0)
            ->update([
                'price' => DB::raw('original_price'),
                'discount' => 0
            ]);

        return back()->with('success', 'book discount destroy ');
    }
}
