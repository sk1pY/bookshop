<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function aboutOrderHome($id)
    {

        $order = Order::where('id', $id)->first();
        return view('home.aboutOrder', compact('order'));
    }

    public function aboutOrderAdmin($id)
    {

        $order_items = OrderItem::where('order_id', $id)->get();
        $order = Order::where('id', $id)->first();

        return view('admin.aboutOrder', compact('order_items','order'));
    }


}
