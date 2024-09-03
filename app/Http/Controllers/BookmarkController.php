<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{


    public function bookmarkAdd($id){
        Bookmark::create(['user_id'=>Auth::id(),'book_id'=>$id]);
        return redirect()->route('home.index');
    }

    public function bookmarkDelete($id){
        Bookmark::where('id', $id) ->delete();
        return redirect()->route('home.index');
    }
}
