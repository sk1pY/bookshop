<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function aboutOrder($id)
    {

        $order = Order::where('id',$id)->first();
     return view('home.aboutOrder',compact('order'));
    }




}
