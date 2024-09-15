<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\BasketItemController;
use App\Http\Controllers\CommentaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
//SEARCH
Route::get('/search',[SearchController::class,'search'])->name('live.search');

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/author/{id}', [BookController::class, 'author'])->name('books.author');
Route::get('/book/{id}', [BookController::class, 'book'])->name('books.book');
Route::get('/category/{id}', [BookController::class, 'categoryBooks'])->name('books.categoryBooks');

Route::get('/basket', [BasketItemController::class, 'index'])->name('basket.index');
Route::post('/basket/add/{id}', [BasketItemController::class, 'addToBasket'])->name('basket.add');
Route::delete('/basket/delete/{id}', [BasketItemController::class, 'delete'])->name('basket.delete');
//ЗАКАЗЫ
Route::post('basket/orderAdd', [BasketItemController::class, 'orderAdd'])->name('basket.order');
//ЗАКЛАДКИ
Route::post('/bookmarkAdd/{id}',[BookmarkController::class,'bookmarkAdd'])->name('bookmark.add');
Route::delete('/bookmarkDelete/{id}',[BookmarkController::class,'bookmarkDelete'])->name('bookmark.delete');

//HOME PROFILE
Route::get('/profile',[HomeController::class,'index'])->name('home.index');
Route::get('/profile/bought',[HomeController::class,'bought'])->name('home.bought');
Route::get('/profile/bought/{order}',[HomeController::class,'aboutBought'])->name('home.aboutBought');
Route::get('/profile/info',[HomeController::class,'info'])->name('home.info');
Route::patch('/profile/infoUpdate/{id}',[HomeController::class,'infoUpdate'])->name('home.infoUpdate');

Route::get('/profile/bookmark',[HomeController::class,'bookmark'])->name('home.bookmark');
Route::get('/profile/commentaries',[HomeController::class,'commentaries'])->name('home.commentaries');
//ПодробнееОбЗаказе
Route::get('/home/order/{id}',[OrderController::class.'aboutOrder'])->name('home.order');


//ADMIN
Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
Route::get('/admin/books',[AdminController::class,'books'])->name('admin.books');
Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin.orders');
Route::get('/admin/addBookView',[AdminController::class,'addBookView'])->name('admin.addBookView');
Route::post('/admin/addBook',[AdminContrsoller::class,'addBook'])->name('admin.addBook');
Route::delete('/admin/deleteBook/{idBook}',[AdminController::class,'deleteBook'])->name('admin.deleteBook');
Route::put('/admin/updateBook/{idBook}',[AdminController::class,'updateBook'])->name('admin.updateBook');
Route::post('/admin/addCategory',[AdminController::class,'addCategory'])->name('admin.addCategory');
Route::get('/admin/addCategoryView',[AdminController::class,'addCategoryView'])->name('admin.addCategoryView');
Route::patch('/admin/addStatusOrder/{id}',[AdminController::class,'addStatusOrder'])->name('admin.addStatusOrder');

//Comment
Route::post('/book/{id}/commentAdd',[CommentaryController::class,'commentAdd'])->name('comment.add');
Route::delete('/book/{id}/commentDelete',[CommentaryController::class,'commentDelete'])->name('comment.delete');

