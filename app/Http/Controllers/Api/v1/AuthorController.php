<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
class AuthorController extends Controller
{
    public function index(){
        return Author::all();
    }

    public function show(Author $author){


        return $author;
    }
}
