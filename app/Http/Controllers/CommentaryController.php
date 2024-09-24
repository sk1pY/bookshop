<?php

namespace App\Http\Controllers;

use App\Models\Commentary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaryController extends Controller
{

    public function commentaries()
    {
        $user = Auth::user();
        $commentaries = Commentary::where('user_id', Auth::id())->get();
        return view('home.commentaries', compact('commentaries'));
    }
    public function commentAdd(Request $request, $id)
    {
        $comment = Commentary::create(['text' => request('text'), 'book_id' => $id, 'rating' => request('rating'),'user_id'=>Auth::id()]);


        $avgRating = Commentary::with('book')->avg('rating');
        $roundAvgRating = round($avgRating, 2);

        $bookObj = $comment->book;
        $bookObj->avgRating = $roundAvgRating;
        $bookObj->save();

        return redirect()->route('books.book',$id);
    }
    public function commentDelete($id)
    {
        Commentary::destroy($id);
        return redirect()->route('home.commentaries');

    }
}
