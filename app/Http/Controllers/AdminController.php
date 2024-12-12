<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\Book;
use App\Models\Category;
use App\Models\DeliveryAddress;
use App\Models\Historyorder;
use App\Models\Historyorders;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $countOrders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->count();
        return view('admin.layouts.index');
    }



    public function users()
    {
        $users = User::get();
        return view('admin.users', compact('users'));
    }

    public function discount()
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->get();
        $booksWithoutDiscount = Book::all();
        $authors = Author::all();
        return view('admin.discount', compact('authors', 'booksWithDiscount', 'booksWithoutDiscount'));
    }

    public function discountAdd(Request $request)
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
        return redirect()->route('admin.discount.index');
    }


    public function discountDeleteAll()
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->get();


        $booksWithDiscount->each(function ($item) {
            $item->price = $item->priceBeforeDiscount;
            $item->discount = 0;
            $item->save();
        });
        return redirect()->route('admin.discount.destroyAll');

    }

    public function discountDelete($id)
    {

        $item = Book::findorfail($id);
        $item->price = $item->priceBeforeDiscount;
        $item->discount = 0;
        $item->save();
        return redirect()->route('admin.discount.index');

    }

    public function addresses(){

        $addresses = DeliveryAddress::all();
        return view('admin.addresses',compact('addresses'));

    }
    public function addresses_store(Request $request){

        DeliveryAddress::create([
            'address' => $request->input('address'),
        ]);

        return redirect()->route('admin.addresses.index');

    }
    public function addresses_update(Request $request,DeliveryAddress $address){

        $address->update([
            'address' => $request->input('address'),
        ]);

        return redirect()->route('admin.addresses.index');

    }
    public function addresses_destroy(DeliveryAddress $address){

        $address->delete();

        return redirect()->route('admin.addresses.index');

    }



}
