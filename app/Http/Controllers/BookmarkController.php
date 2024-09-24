<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{


    public function bookmark()
    {
        $user = Auth::user();
        $bookmarks = Bookmark::where('user_id', Auth::id())->get();
        return view('home.bookmark', compact('bookmarks'));
    }

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
