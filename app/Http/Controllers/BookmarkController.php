<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{


//    public function bookmarkAdd($id){
//        Bookmark::create(['user_id'=>Auth::id(),'book_id'=>$id]);
//        return redirect()->route('books.index')->with('success', 'Книга добавлена в избранное');
//    }

    public function bookmarkAdd(Request $request)
    {
        $taskId = $request->input('bookmark_id');
        $bookmark = Bookmark::where(['user_id' => Auth::id(),'book_id' => $taskId])->first();
        if($bookmark){
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmark' => false]);
        }
        Bookmark::create([
            'user_id' => Auth::user() -> id,
            'book_id' => $taskId]);
        return response()->json(['success' => true,  'bookmark' => true]);

    }

    public function bookmarkDelete($id){
        Bookmark::where('id', $id) ->delete();
        return redirect()->route('home.bookmark');
    }
}
