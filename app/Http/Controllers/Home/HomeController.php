<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInfoRequest;
use App\Models\Address;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function info()
    {
        $user = Auth::user();
        $addresses = Address::get();

        return view('home.info', compact('user', 'addresses'));
    }

    public function infoUpdate(UpdateInfoRequest $request, User $user)
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            if ($value !== null && $value !== '' && $value !== $user->$key) {
                $user->$key = $value;
            }
        }

        $user->save();

        return to_route('home.info.index');

    }


    public function destroy(User $user){
        $user->delete();
        return to_route('books.index');

    }

}
