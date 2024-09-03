<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $orders = Order::where('user_id',Auth::id())->get();

        $bookmarks =  Bookmark::where('user_id', Auth::id())->get();

        return view('home.index',compact('bookmarks','user','orders'));
    }
}
