<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public const NEW = 'Новый заказ';
    public const READY = 'Готов к выдаче';
    public const CANCEL = 'Отменен';
    public const RECEIVED = 'Получен';
    public function orders():View
    {
        $orders = Order::whereIn('status', [self::NEW, self::READY])->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function orderHistory():View
    {
        $orders = Order::whereIn('status', [self::CANCEL, self::RECEIVED])->paginate(10);
        return view('admin.orders.order_history', compact('orders'));
    }

    public function addStatusOrder(Order $order):RedirectResponse
    {
        $order->update(['status' => request('status')]);
        $booksBoughtUpdate =  $order->order_items()->get();

        if ($order->status === self::RECEIVED) {
            $booksBoughtUpdate->each(function ($item) {
                 Book::where(['id' => $item->book_id])
                    ->increment('numberOfPurchased', $item->quantity);
            });

        }
        if ($order->status === self::CANCEL) {
            $booksBoughtUpdate->each(function ($item) {
                Book::where(['id' => $item->book_id])
                    ->increment('stock', $item->quantity);
            });
        }
        return back()->with('success', 'Статус заказа обновлен');

    }
    public function aboutOrderAdmin(Order $order):View
    {
        $order_items = $order->order_items()->get();
        $order_items->each(function($q){
         $q->sum_res = $q->quantity*$q->book->price;
        });

        return view('admin.orders.show', compact('order_items','order'));
    }
}
