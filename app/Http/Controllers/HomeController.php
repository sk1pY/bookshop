<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Commentary;
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

    public function bought()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('home.bought', compact('orders'));
    }

    public function aboutBought($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::where('order_id', $id)->get();
        return view('home.aboutBought', compact('order','orderItems'));
    }

    public function info()
    {
        $user = Auth::user();
        return view('home.info', compact('user'));
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

        return redirect()->route('home.info');

    }




}
