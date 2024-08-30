<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\BasketItemsController;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/author/{id}', [BookController::class, 'author'])->name('books.author');
Route::get('/book/{id}', [BookController::class, 'book'])->name('books.book');
Route::get('/category/{id}', [BookController::class, 'categoryBooks'])->name('books.categoryBooks');


Route::get('/basket', [BasketItemsController::class, 'index'])->name('basket.index');
Route::post('/basket/add/{id}', [BasketItemsController::class, 'addToBasket'])->name('basket.add');
Route::delete('/basket/delete/{id}', [BasketItemsController::class, 'delete'])->name('basket.delete');
//ЗАКАЗЫ
Route::post('basket/orderAdd', [BasketItemsController::class, 'orderAdd'])->name('basket.order');

Route::get('/home',function (){
    return view('home.index');
})->name('home.index');

//ADMIN

Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
Route::post('/admin/addBook',[AdminController::class,'addBook'])->name('admin.addBook');
Route::delete('/admin/deleteBook/{idBook}',[AdminController::class,'deleteBook'])->name('admin.deleteBook');
Route::put('/admin/updateBook/{idBook}',[AdminController::class,'updateBook'])->name('admin.updateBook');
Route::post('/admin/addCategory',[AdminController::class,'addCategory'])->name('admin.addCategory');



