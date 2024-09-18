<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Basket;
use App\Models\Basket_items;
use App\Models\Book;
use App\Models\Category;
use App\Models\Historyorder;
use App\Models\Historyorders;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index',);
    }

    public function addAuthorsView()
    {
      $authors =   Author::all();
        return view('admin.authorAdd',compact('authors'));
    }
    public function addAuthor(Request $request)
    {
    $validatedData = $request->validate([
        'name' => 'required|alpha|max:30',
        'surname' => 'required|alpha|max:30',
    ],[
        'name.required' => 'напишите имя автора',
        'surname.required' => 'напишите фамилию автора',
        '*.alpha' => 'имя должно состоять тольок из букв'
    ]);
        Author:: create([
            'name'=>$request->input('name'),
            'surname'=>$request->input('surname'),
            ]);

        return redirect()->route('admin.addAuthorsView');
    }
    public function deleteAuthor($id)
    {
        Author::destroy($id);
        return redirect()->route('admin.addAuthorsView');
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
        ],[
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
        $discount = $request->input('discount');
        $authorPersonalDiscountBooks->each(function ($item) use ($discount) {
            $item->priceBeforeDiscount = $item->price;
            $item->price = $item->price - round($item->price * $discount * 0.01, 2);
            $item->discount = $discount;
            $item->save();
        });
        return redirect()->route('admin.discount');
    }


    public function discountDeleteAll()
    {
        $booksWithDiscount = Book::where('discount', '>', 0)->get();


        $booksWithDiscount->each(function ($item) {
            $item->price = $item->priceBeforeDiscount;
            $item->discount = 0;
            $item->save();
        });
        return redirect()->route('admin.discount');

    }

    public function discountDelete($id)
    {
        $item = Book::findorfail($id);
        $item->price = $item->priceBeforeDiscount;
        $item->discount = 0;
        $item->save();
        return redirect()->route('admin.discount');

}

public
function orders()
{
    $orders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->get();

    return view('admin.orders', compact('orders'));
}

public
function books()
{
    $books = Book::orderBy('created_at', 'desc')->get();

    return view('admin.books', compact('books'));
}

public
function addBookView()
{
    $authors = Author::all();
    $categories = Category::all();

    return view('admin.bookAdd', compact('authors', 'categories'));
}

public
function addBook(Request $request)
{
   // dd($request->all());
    $validatedData = $request->validate([
        'title' => 'string|required',
        'description' => 'string|required',
        'author' => 'string|nullable',
        'category' => 'string|nullable',
        'price' => 'numeric|required|min:0',
    ]);
    $authorId = optional(Author::where('surname', $validatedData['author'])->first())->id;
    $categoryId = optional(Category::where('name', $validatedData['category'])->first())->id;
    $book = Book::create([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'price' => $validatedData['price'],
        'author_id' => $authorId,
        'category_id' =>$categoryId
    ]);

    return redirect()->route('admin.index');
}

public
function deleteBook($id)
{
    Book:: destroy($id);
    return redirect()->route('admin.index');

}

public
function updateBook($id, Request $request)
{
    // dd($id);
    $book = Book::find($id);
    $validatedData = request()->validate([
        'title' => 'required|string|max:255'
    ]);

    $book->update(['title' => $validatedData['title']]);
    return redirect()->route('admin.books');

}

public
function addCategoryView()
{

    return view('admin.categoryAdd');
}

public
function addCategory(Request $request)
{
    // dd(request('category_name'));
    Category::create(['name' => request('category_name')]);
    return redirect()->route('admin.index');
}

public
function addStatusOrder(Request $request, $id)
{
    // dd($request->input('status'));
    $orderStatus = Order::findOrFail($id);
    $orderStatus->update(['status' => $request->input('status')]);
//        if($request->input('status') ==  'Получен'){
//
//        }
    return redirect()->route('admin.orders');

}
}
