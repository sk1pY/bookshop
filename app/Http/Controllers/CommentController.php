<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $validate = $request->validate([
            'text'  => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5'
        ]);
        Comment::create(array_merge($validate,['book_id'=>$book->id,'user_id'=>Auth::id() ]));

        $avgRating =  $book->commentaries()->avg('rating');
        $book->avgRating = $avgRating;
        $book-> save();

        return to_route('books.book',$book)->with('success', 'Comment added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book,Comment $comment)
    {
        abort_if($book->id !== $comment->book_id, 404);
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'text' => 'required|string|max:600',
        ]);

        $comment->update([
            'text' => $validated['text'],
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'updated_at' => now(),
        ]);


        return back()->with('success', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book,Comment $comment)
    {
        abort_if($book->id !== $comment->book_id, 404);
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully');
    }
}
