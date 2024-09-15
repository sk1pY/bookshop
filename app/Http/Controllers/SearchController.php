<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $books = Book::where('title', 'LIKE', '%' . $request->search . "%")->get();
            if ($books->count() > 0) {
                foreach ($books as $book) {
                    $output .= '<a class=" link-secondary text-decoration-none text-dark" href="'.route('books.book',$book->id). '"><li class="list-group-item ">'.$book->title.'</li></a>';
                }
            } else {
                $output = '<li class="list-group-item">No results found</li>';
            }
            return response($output);
        }
    }
}
