<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        Log::info($request->input('search'));
        $books = Book::where('title', 'like', '%' . $request->input('search') . '%')->get();

        $html = '';
        foreach ($books as $book) {
            $html .= view('partials.book-card', compact('book'))->render();
        }
        return response()->json(['html' => $html]);
    }
}
