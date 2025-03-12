<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $status = $request->query('status','all');

        if($status == 'all'){
            $orders = Order::orderBy('created_at','desc')->get();

        }elseif($status == 'delivered'){
            $orders = Order::where('status', 'Получен')->get();

        }

        return view('home.orders', compact('orders'));
    }

    public function about_orders(Order $order)
    {
        $orderItems =  $order->order_items()->get();

        return view('home.about_order', compact('order','orderItems'));
    }

    public function cancel_order(Order $order){

        $booksBoughtUpdate = $order->order_items()->get();

        $booksBoughtUpdate->each(function ($item) {
            Book::where(['id' => $item->book_id])
                ->increment('stock', $item->quantity);
        });

        $order->delete();

        return redirect() -> route('home.orders.index')->with('success','Заказ успешно отменен');
    }


}
