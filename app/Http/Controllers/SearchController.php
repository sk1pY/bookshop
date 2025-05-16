<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {
       // Log::info($request->input('search'));
       // Log::info($request->input('category_slug'));
        $category_slug = $request->input('category_slug');

        if ($category_slug) {
            $category = Category::where('slug', $category_slug)->first();

            if ($category) {
                $books = Book::where('title', 'like', '%' . $request->input('search') . '%')
                    ->where('category_id', $category->id)
                    ->get();
            } else {
                $books = collect();
            }

        } else {
            $books = Book::where('title', 'like', '%' . $request->input('search') . '%')->get();
        }

        $html = '';
        foreach ($books as $book) {

            $html .= view('partials.book-card', compact('book'))->render();
        }
        return response()->json(['html' => $html]);
    }
}
