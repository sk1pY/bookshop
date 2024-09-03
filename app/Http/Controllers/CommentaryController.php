<?php

namespace App\Http\Controllers;

use App\Models\Commentary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaryController extends Controller
{


    public function commentAdd(Request $request, $id)
    {
        $comment = Commentary::create(['text' => request('text'), 'book_id' => $id, 'rating' => request('rating')]);


        $avgRating = Commentary::with('book')->avg('rating');
        $roundAvgRating = round($avgRating, 2);

        $bookObj = $comment->book;
        $bookObj->avgRating = $roundAvgRating;
        $bookObj->save();

        return redirect()->route('books.book',$id);
    }
    public function commentDelete($id)
    {
        Commentary::where('id', $id)->delete();
        return redirect()->route('books.book', $id);

    }
}
