<?php

namespace App\Actions\Book;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Class FilterBooks {

    public function execute($booksQuery, ?string $filter)
    {
          return  match ($filter) {
                'cheap' => $booksQuery->orderBy('price'),
                'expensive' => $booksQuery->orderBy('price', 'desc'),
                'rating' => $booksQuery->orderBy('avgRating', 'desc'),
                default => $booksQuery->latest()
            };
    }
}
