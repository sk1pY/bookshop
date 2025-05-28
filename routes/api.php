<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookController as v1Book;
use App\Http\Controllers\Api\V1\AuthorController as v1Author;
use App\Http\Controllers\Api\V1\CategoryController as v1Category;
use App\Http\Controllers\Api\V1\AddressController as v1Address;

//BOOKS
Route::apiResource('v1/books', v1Book::class);
Route::get('v1/books/{book}/commentaries', [v1Book::class, 'commentaries']);
//STOCK BOOKS
Route::get('v1/stock/{book}', [v1Book::class, 'stock'])->name('books.stock');

//AUTHORS
Route::get('v1/authors', [v1Author::class, 'index'])->name('authors.index');
Route::get('v1/authors/{author}', [v1Author::class, 'show'])->name('authors.show');

//CATEGORIES
Route::get('v1/categories', [v1Category::class, 'index'])->name('categories.index');
Route::get('v1/categories/{category}', [v1Category::class, 'show'])->name('categories.show');

//COMMENTARIES


//ПУНКТЫ САМОВЫВОЗА
Route::get('v1/address', [v1Address::class, 'index'])->name('address.index');


