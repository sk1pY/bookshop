<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Bookmark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class BookmarkController extends Controller
{
    public function index():View
    {
        $user = Auth::user();
        $basket = app('basket');
        $bookmarks = $user->bookmarks()->get();

        $quantities = $basket->basket_items()->pluck('quantity', 'book_id');

        $bookmarks->each(function ($bookmark) use ($quantities) {
            $bookmark->quantity = $quantities[$bookmark->book_id] ?? 0;
        });

        return view('home.bookmark', compact('bookmarks'));
    }
    public function store(Request $request):JsonResponse
    {
        $bookId = $request->input('book_id');
        $bookmark = Bookmark::with('book.author')
            ->where(['user_id' => Auth::id(), 'book_id' => $bookId])
            ->first();
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmark' => false]);
        }
        Bookmark::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId]);
        return response()->json(['success' => true, 'bookmark' => true]);
    }


}
