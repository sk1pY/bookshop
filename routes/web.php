<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/author/{id}', [BookController::class, 'author'])->name('books.author');
Route::get('/book/{id}', [BookController::class, 'book'])->name('books.book');
Route::get('/category/{id}', [BookController::class, 'categoryBooks'])->name('books.categoryBooks');


Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');
Route::post('/basket/add', [BasketController::class, 'add'])->name('basket.add');
Route::delete('/basket/delete/{id}', [BasketController::class, 'delete'])->name('basket.delete');


Route::get('/home',function (){
    return view('home.index');
})->name('home.index');

