<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public const NEW = 'Новый заказ';
    public const READY = 'Готов к выдаче';
    public const CANCEL = 'Отменен';
    public const RECEIVED = 'Получен';
    public function orders()
    {
        $orders = Order::whereIn('status', [OrderController::NEW,OrderController::READY])->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function orderHistory()
    {
        $orders = Order::whereIn('status', [OrderController::CANCEL, OrderController::RECEIVED])->paginate(10);
        return view('admin.orders.order_history', compact('orders'));
    }

    public function addStatusOrder(Order $order)
    {
        $order->update(['status' => request('status')]);
        $booksBoughtUpdate =  $order->order_items()->get();

        if ($order->status == OrderController::RECEIVED) {
            $booksBoughtUpdate->each(function ($item) {
                 Book::where(['id' => $item->book_id])
                    ->increment('numberOfPurchased', $item->quantity);
            });

        }
        if ($order->status == OrderController::CANCEL) {
            $booksBoughtUpdate->each(function ($item) {
                Book::where(['id' => $item->book_id])
                    ->increment('stock', $item->quantity);
            });
        }
        return back()->with('success', 'Статус заказа обновлен');

    }
    public function aboutOrderAdmin(Order $order)
    {
        $order_items = $order->order_items()->get();
        $order_items->each(function($q){
         $q->sum_res = $q->quantity*$q->book->price;
        });

        return view('admin.orders.show', compact('order_items','order'));
    }
}
