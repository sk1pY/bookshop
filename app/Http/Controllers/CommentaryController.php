<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Commentary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaryController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $comments = Commentary::where('user_id', Auth::id())->get();
        return view('home.comments', compact('comments'));
    }
    public function store(Request $request, Book $book)
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
    public function destroy(Commentary $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index');

    }
}
