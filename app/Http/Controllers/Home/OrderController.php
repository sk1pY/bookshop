<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends Controller
{
    public function aboutOrderHome($id)
    {

        $order = Order::where('id', $id)->first();
        return view('home.aboutOrder', compact('order'));
    }

    public function cancel_order(Order $order){

        $booksBoughtUpdate = OrderItem::where(['order_id' => $order->id])->get();

        //ПРОХОДИТ ПО КНИГАМ КОТОРЫЕ БЫЛИ ОТМЕНЕНЫ И ПРИБАВЛЯЕМ К СТОКУ
        $booksBoughtUpdate->each(function ($item) {
            Book::where(['id' => $item->book_id])
                ->increment('stock', $item->quantity);
        });

        $order->delete();

        return redirect() -> route('home.orders.index')->with('success','Заказ успешно отменен');
    }


}
