<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
    public function commentAdd(Request $request, Book $book)
    {
        $validate = $request->validate([
            'text'  => 'required|string|max:1000',
            'rating' => 'required|between:1,5'
        ]);
         Commentary::create(array_merge($validate,['book_id'=>$book->id,'user_id'=>Auth::id() ]));

      $avgRating =  $book->commentaries()->avg('rating');
       $book->avgRating = $avgRating;
       $book-> save();

        return redirect()->route('books.book',$book);
    }
    public function commentDelete($id)
    {
        Commentary::destroy($id);
        return redirect()->route('home.commentaries.index');

    }
}
