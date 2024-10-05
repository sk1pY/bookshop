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

        return view('admin.index');
    }

    public function addAuthorsView()
    {
        $authors = Author::all();
        return view('admin.authorAdd', compact('authors'));
    }

    public function addAuthor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|alpha|max:30',
            'surname' => 'required|alpha|max:30',
        ], [
            'name.required' => 'напишите имя автора',
            'surname.required' => 'напишите фамилию автора',
            '*.alpha' => 'только буквы'
        ]);
        Author:: create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
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
    function orderHistory()
    {
        $orders = Order::whereIn('status',['Отменен','Получен'])->get();
        return view('admin.orderHistory',compact('orders'));
    }

    public
    function books()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.books', compact('books'));
    }

    public
    function addBookView()
    {
        $authors = Author::all();
        $categories = Category::all();

        return view('admin.bookAdd', compact('authors', 'categories'));
    }

    public function addBook(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required|min:0',
            'stock' => 'numeric|required|min:0',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('booksImages', 'public');
            $fileName = basename($path);
                  }

        $authorId = optional(Author::where('surname', $request->input('author'))->first())->id;
        $categoryId = optional(Category::where('name', $request->input('category'))->first())->id;
        $book = Book::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'author_id' => null,
            'category_id' => $categoryId,
            'image' => $fileName
        ]);

        return redirect()->route('admin.addBookView')->with('successBookAdd', 'Книга добавлена');
    }

    public
    function deleteBook($id)
    {
        Book:: destroy($id);
        return redirect()->route('admin.books');

    }

    public
    function updateBook($id, Request $request)
    {
        $book = Book::find($id);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $book->update(['title' => $validatedData['title']]);
        return redirect()->route('admin.books');

    }

    public function addCategoryView()
    {

        return view('admin.categoryAdd');
    }

    public
    function addCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|alpha|max:30'
        ]);
        Category::create(['name' => $validatedData['category_name']]);
        return redirect()->route('admin.addCategoryView')->with('successCategoryAdd', 'Категория добавлена');
    }

    public function addStatusOrder(Request $request, $id)
    {
        $orderStatus = Order::findOrFail($id);
        $orderStatus->update(['status' => $request->input('status')]);

        if ($orderStatus->status == 'Получен') {
            $booksBoughtUpdate = OrderItem::where(['order_id' => $id])->get();
            $booksBoughtUpdate->each(function ($item) {
                $book = Book::where(['id' => $item->book_id])->first();
                $book->numberOfPurchased += $item->quantity;
                $book->save();
            });
        }
        if ($orderStatus->status == 'Отмена заказа') {
            $booksBoughtUpdate = OrderItem::where(['order_id' => $id])->get();
            $booksBoughtUpdate->each(function ($item) {
                $book = Book::where(['id' => $item->book_id])->first();
                $book->stock += $item->quantity;
                $book->save();
            });
        }

        return redirect()->route('admin.orders')->with('successStatusUpdate', 'Статус заказа обновлен');

    }
}
