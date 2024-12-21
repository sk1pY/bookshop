<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->get();
        $booksWithoutDiscount = Book::all();
        $authors = Author::all();
        return view('admin.discount', compact('authors', 'booksWithDiscount', 'booksWithoutDiscount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ], [
            'discount.required' => 'Введите процент скидки',
            'discount.numeric' => 'Введите число',
            'discount.min' => 'больше 0',
            'discount.max' => 'меньше 100'
        ]);

        if ($request->input('authorPersonalDiscount') !== null) {
            $authorId = Author:: where('surname', $request->input('authorPersonalDiscount'))->first()->id;
            $authorPersonalDiscountBooks = Book:: where('author_id', $authorId)->get();
        } elseif ($request->input('bookName') !== null) {
            $authorPersonalDiscountBooks = Book::where('title', $request->input('bookName'))->get();

        } else {
            $authorPersonalDiscountBooks = Book::get();
        }
        $discount = $validatedData['discount'];
        $authorPersonalDiscountBooks->each(function ($item) use ($discount) {
            $item->priceBeforeDiscount = $item->price;
            $item->price = $item->price - round($item->price * $discount * 0.01, 2);
            $item->discount = $discount;
            $item->save();
        });
        return redirect()->route('admin.discounts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Book::findorfail($id);
        $item->price = $item->priceBeforeDiscount;
        $item->discount = 0;
        $item->save();
        return redirect()->route('admin.discounts.index');
    }
    public function discountDeleteAll()
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->get();


        $booksWithDiscount->each(function ($item) {
            $item->price = $item->priceBeforeDiscount;
            $item->discount = 0;
            $item->save();
        });
        return redirect()->route('admin.discounts.destroyAll');

    }
}
