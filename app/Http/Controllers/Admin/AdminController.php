<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Basket_items;
use App\Models\Historyorders;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        $countOrders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->count();
        return view('admin.layouts.index',compact('countOrders'));
    }

}
