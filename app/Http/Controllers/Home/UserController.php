<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInfoRequest;
use App\Models\Address;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function infoUser()
    {
        $user = Auth::user();
        $addresses = Address::get();

        return view('home.info', compact('user', 'addresses'));
    }

    public function infoUserUpdate(UpdateInfoRequest $request)
    {
        $validated = $request->validated();
        auth()->user()->update($validated);
        return back()->with('success', 'success');

    }

    public function userDelete()
    {
        auth()->user()->delete();
        return back()->with('success', 'success');

    }

}
