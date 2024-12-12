<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
ini_set('display_errors', 1);
error_reporting(E_ALL);

class BookmarkController extends Controller
{


    public function index()
    {
        $user = Auth::user();
        $bookmarks = Bookmark::where('user_id', Auth::id())->get();
        return view('home.bookmark', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        $taskId = $request->input('bookmark_id');
        $bookmark = Bookmark::with('book.author')->where(['user_id' => Auth::id(),'book_id' => $taskId])->first();
        if($bookmark){
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmark' => false]);
        }
        Bookmark::create([
            'user_id' => Auth::user() -> id,
            'book_id' => $taskId]);
        return response()->json(['success' => true,  'bookmark' => true]);

    }

    public function destroy(Bookmark $bookmark){
        $bookmark->delete();
        return redirect()->route('home.bookmarks.index');
    }
}
