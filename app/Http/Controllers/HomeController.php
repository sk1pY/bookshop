<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Commentary;
use App\Models\DeliveryAddress;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

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

    public function about_orders($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::where('order_id', $id)->get();
        return view('home.about_order', compact('order','orderItems'));
    }


    public function info()
    {
        $user = Auth::user();
        $addresses = DeliveryAddress::all();
        return view('home.info', compact('user', 'addresses'));
    }

    public function infoUpdate(Request $request, $id)
    {
        //dd($request->all());
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'string|max:255|nullable',
            'birthday' => 'date|nullable',
            'gender' => 'string|max:255|nullable',
            'phone' => 'string|nullable|max:15',
            'address' => 'string|nullable|max:255',
        ]);


        foreach ($validatedData as $key => $value) {
            if ($value !== null && $value !== '' && $value !== $user->$key) {
                $user->$key = $value;
            }
        }

        $user->save();

        return redirect()->route('home.info.index');

    }



}
