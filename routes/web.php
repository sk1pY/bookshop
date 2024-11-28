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
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//КНИГИ
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/author/{id}', [BookController::class, 'author'])->name('books.author');
Route::get('/book/{id}', [BookController::class, 'book'])->name('books.book');
Route::get('/category/{id}', [BookController::class, 'categoryBooks'])->name('books.categoryBooks');

//КОРЗИНА
Route::prefix('basket')->group(function () {
    Route::get('/', [BasketItemController::class, 'index'])->name('basket.index');
    Route::post('/add-to-order', [BasketItemController::class, 'orderAdd'])->name('basket.order');
    Route::post('/add-to-basket/{id}', [BasketItemController::class, 'addToBasket'])->name('basket.add');
    Route::delete('/delete/{id}', [BasketItemController::class, 'delete'])->name('basket.delete');
});


//ЗАКЛАДКИ
Route::prefix('bookmark')->group(function () {
    Route::post('/', [BookmarkController::class, 'bookmarkAdd'])->name('bookmark.add');
    Route::delete('/{id}', [BookmarkController::class, 'bookmarkDelete'])->name('bookmark.delete');
});


//HOME PROFILE
Route::name('home.')->prefix('profile')->group(function () {
    Route::get('/bookmark', [BookmarkController::class, 'bookmark'])->name('bookmark');
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/bought', [HomeController::class, 'bought'])->name('bought');
    Route::get('/bought/{order}', [HomeController::class, 'aboutBought'])->name('aboutBought');
    Route::get('/info', [HomeController::class, 'info'])->name('info');
    Route::patch('/info/{id}', [HomeController::class, 'infoUpdate'])->name('infoUpdate');
});

//ПодробнееОбЗаказе
//Route::get('/home/order/{id}',[OrderController::class,'aboutOrderHome'])->name('home.order');
Route::get('/admin/order/{id}', [OrderController::class, 'aboutOrderAdmin'])->name('admin.order');

//ADMIN
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/books', [AdminController::class, 'books'])->name('admin.books');
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::get('/admin/orderHistory', [AdminController::class, 'orderHistory'])->name('admin.orderHistory');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/authors', [AdminController::class, 'addAuthorsView'])->name('admin.addAuthorsView');
Route::post('/admin/addAuthor', [AdminController::class, 'addAuthor'])->name('admin.addAuthor');
Route::delete('/admin/deleteAuthor/{id}', [AdminController::class, 'deleteAuthor'])->name('admin.deleteAuthor');
Route::get('/admin/discount', [AdminController::class, 'discount'])->name('admin.discount');
Route::post('/admin/addDiscount', [AdminController::class, 'discountAdd'])->name('admin.discountAdd');
Route::delete('/admin/discountDeleteAll', [AdminController::class, 'discountDeleteAll'])->name('admin.discountDeleteAll');
Route::delete('/admin/discountDelete/{id},', [AdminController::class, 'discountDelete'])->name('admin.discountDelete');
Route::get('/admin/addBookView', [AdminController::class, 'addBookView'])->name('admin.addBookView');
Route::post('/admin/addBook', [AdminController::class, 'addBook'])->name('admin.addBook');
Route::delete('/admin/deleteBook/{idBook}', [AdminController::class, 'deleteBook'])->name('admin.deleteBook');
Route::put('/admin/updateBook/{idBook}', [AdminController::class, 'updateBook'])->name('admin.updateBook');
Route::post('/admin/addCategory', [AdminController::class, 'addCategory'])->name('admin.addCategory');
Route::get('/admin/addCategoryView', [AdminController::class, 'addCategoryView'])->name('admin.addCategoryView');
Route::patch('/admin/addStatusOrder/{id}', [AdminController::class, 'addStatusOrder'])->name('admin.addStatusOrder');

//Commentaries
Route::get('/profile/commentaries', [CommentaryController::class, 'commentaries'])->name('home.commentaries');
Route::post('/book/{id}/comment', [CommentaryController::class, 'commentAdd'])->name('comment.add');
Route::delete('/book/comment/{id}', [CommentaryController::class, 'commentDelete'])->name('comment.delete');

//404
//Route::fallback(function () {
//
//        return '404 maaan';
//});

Route::post('/example', function () {
    return response() -> download('kek.pdf');
});
