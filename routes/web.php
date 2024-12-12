<?php

use App\Http\Controllers\Admin\AuthorController as AdminAuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BasketItemController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentaryController;
use App\Http\Controllers\Home\BookmarkController as HomeBookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//Автор
Route::get('/author/{id}', [AuthorController::class, 'index'])->name('author.index');

//КНИГИ
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/book/{id}', [BookController::class, 'book'])->name('books.book');

//КАТЕГОРИИ
Route::get('/category/{category}', [\App\Http\Controllers\UserCategoryController::class, 'categoryBooks'])->name('categories.public.show');

//КОРЗИНА
Route::prefix('basket')->group(function () {
    Route::get('/', [BasketItemController::class, 'index'])->name('basket.index');
    Route::post('/add-to-order', [BasketItemController::class, 'orderAdd'])->name('basket.order');
    Route::post('/add-to-basket/{id}', [BasketItemController::class, 'addToBasket'])->name('basket.add');
    Route::delete('/delete/{id}', [BasketItemController::class, 'delete'])->name('basket.delete');
    Route::delete('/delete_all_book/{book}', [BasketItemController::class, 'delete_from_basket'])->name('basket.deleteAll');
});


//HOME PROFILE
Route::name('home.')->prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/bookmarks', [HomeBookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [HomeBookmarkController::class, 'store'])->name('bookmarks.store');
    Route::post('/bookmarks', [HomeBookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{bookmark}', [HomeBookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/orders', [HomeController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [HomeController::class, 'about_orders'])->name('orders.show');
    Route::delete('/orders/{order}', [\App\Http\Controllers\Home\OrderController::class, 'cancel_order'])->name('orders.destroy');
    Route::get('/info', [HomeController::class, 'info'])->name('info.index');
    Route::patch('/info/{id}', [HomeController::class, 'infoUpdate'])->name('info.update');
    Route::get('/commentaries', [CommentaryController::class, 'commentaries'])->name('commentaries.index');
});

//Commentaries
Route::post('/book/{id}/comment', [CommentaryController::class, 'commentAdd'])->name('comment.store');
Route::delete('/book/comment/{id}', [CommentaryController::class, 'commentDelete'])->name('comment.destroy');

//ADMIN-PANEL
Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    //Books
    Route::resource('books', AdminBookController::class)->except('show', 'edit');
    //Categories
    Route::resource('categories', AdminCategoryController::class);
    //Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    //Orders
    Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders.index');
    Route::get('/orders/history', [AdminOrderController::class, 'orderHistory'])->name('orders.history');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'addStatusOrder'])->name('orders.status.update');
    Route::get('/orders/{id}', [AdminOrderController::class, 'aboutOrderAdmin'])->name('orders.show');
    //Authors
    Route::resource('authors', AdminAuthController::class);
    //Discount
    Route::get('/discount', [AdminController::class, 'discount'])->name('discount.index');
    Route::post('/discount', [AdminController::class, 'discountAdd'])->name('discount.store');
    Route::delete('/discount', [AdminController::class, 'discountDeleteAll'])->name('discount.destroyAll');
    Route::delete('/discount/{id}', [AdminController::class, 'discountDelete'])->name('discount.destroy');
    //Interface
    Route::get('/interface', [\App\Http\Controllers\Admin\InterfaceController::class, 'index'])->name('interface.index');

    Route::get('/addresses',[AdminController::class, 'addresses'])->name('addresses.index');
    Route::post('/addresses',[AdminController::class, 'addresses_store'])->name('addresses.store');
    Route::patch('/addresses/{address}',[AdminController::class, 'addresses_update'])->name('addresses.update');
    Route::delete('/addresses/{address}',[AdminController::class, 'addresses_destroy'])->name('addresses.destroy');
});

//404
//Route::fallback(function () {
//
//        return '404 maaan';
//});


