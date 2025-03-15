<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        $orders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function orderHistory()
    {
        $orders = Order::whereIn('status', ['Отменен', 'Получен'])->get();
        return view('admin.orders.order_history', compact('orders'));
    }

    public function addStatusOrder(Request $request, $id)
    {
        $orderStatus = Order::findOrFail($id);
        $orderStatus->update(['status' => $request->input('status')]);

        if ($orderStatus->status == 'Получен') {
            $booksBoughtUpdate = OrderItem::where(['order_id' => $id])->get();

            $booksBoughtUpdate->each(function ($item) {
                 Book::where(['id' => $item->book_id])
                    ->increment('numberOfPurchased', $item->quantity);

            });

        }
        if ($orderStatus->status == 'Отмена заказа') {
            $booksBoughtUpdate = OrderItem::where(['order_id' => $id])->get();

            $booksBoughtUpdate->each(function ($item) {
                Book::where(['id' => $item->book_id])
                    ->increment('stock', $item->quantity);
            });
        }
        return redirect()->route('admin.orders.index')->with('successStatusUpdate', 'Статус заказа обновлен');

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
