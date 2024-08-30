<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class BookControllerTest extends TestCase
{

    public function categoryBooks()
    {
        $users = DB::select('select * from books');
    }
}
