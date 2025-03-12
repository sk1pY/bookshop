<?php

use App\Http\Controllers\Admin\AddressesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BasketItemController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentaryController;
use App\Http\Controllers\Home\BookmarkController as HomeBookmarkController;
use App\Http\Controllers\Home\OrderController as HomeOrderController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\RolesPermissions\PermissionController;
use App\Http\Controllers\RolesPermissions\RoleController;
use App\Http\Controllers\RolesPermissions\RolePermissionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserCategoryController;
use Illuminate\Support\Facades\Route;

//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//Автор
Route::get('/authors/{author}', [AuthorController::class, 'index'])->name('authors.index');

//КНИГИ
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/book/{book}', [BookController::class, 'book'])->name('books.book');


//------------------------------------------------КАТЕГОРИИ------------------------------------------------
Route::get('/category/{category}', [UserCategoryController::class, 'categoryBooks'])->name('categories.public.show');
Route::get('/bestsellers', [CategoryController::class, 'categories_top'])->defaults('type','bestsellers')->name('bestsellers');
Route::get('/newest', [CategoryController::class, 'categories_top'])->defaults('type','newest')->name('newest');
Route::get('/sale', [CategoryController::class, 'categories_top'])->defaults('type','sales')->name('sale');

//------------------------------------------------КОРЗИНА------------------------------------------------
Route::prefix('basket')->group(function () {
    Route::get('/', [BasketItemController::class, 'index'])->name('basket.index');
    Route::post('/add-to-order', [BasketItemController::class, 'orderAdd'])->name('basket.order');
    Route::post('/add-to-basket/{id}', [BasketItemController::class, 'addToBasket'])->name('basket.add');
    Route::delete('/delete/{id}', [BasketItemController::class, 'delete'])->name('basket.delete');
    Route::delete('/delete_all_book/{book}', [BasketItemController::class, 'delete_all_books'])->name('basket.deleteAll');
});


//------------------------------------------------HOME PROFILE------------------------------------------------
Route::name('home.')->prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/bookmarks', [HomeBookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [HomeBookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{bookmark}', [HomeBookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/orders', [HomeOrderController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [HomeOrderController::class, 'about_orders'])->name('orders.show');
    Route::delete('/orders/{order}', [HomeOrderController::class, 'cancel_order'])->name('orders.destroy');
    Route::get('/info', [HomeController::class, 'info'])->name('info.index');
    Route::patch('/info/{user}', [HomeController::class, 'infoUpdate'])->name('info.update');
    Route::get('/commentaries', [CommentaryController::class, 'commentaries'])->name('commentaries.index');
});

//------------------------------------------------Commentaries------------------------------------------------
Route::post('/book/{id}/comment', [CommentaryController::class, 'commentAdd'])->name('comment.store');
Route::delete('/book/comment/{id}', [CommentaryController::class, 'commentDelete'])->name('comment.destroy');

//------------------------------------------------ADMIN-PANEL--------------------------------------------//
Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    //Roles and Permission
    Route::get('/permissions_roles', [RolePermissionController::class, 'index'])->name('permissions_roles.index');
    Route::put('/permissions_roles/{role}', [RolePermissionController::class, 'update'])->name('permissions_roles.update');
    Route::put('/role_for_user/{user}', [RolePermissionController::class, 'role_for_user'])->name('role_for_user.update');
    //
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    //ROLES
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    //PERMISSION
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    //Books
    Route::resource('books', AdminBookController::class)->except('show', 'edit');
    //Categories
    Route::resource('categories', AdminCategoryController::class);
    //Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    //Orders
    Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders.index');
    Route::get('/orders/history', [AdminOrderController::class, 'orderHistory'])->name('orders.history');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'addStatusOrder'])->name('orders.status.update');
    Route::get('/orders/{order}', [AdminOrderController::class, 'aboutOrderAdmin'])->name('orders.show');
    //Authors
    Route::resource('authors', AdminAuthController::class);
    //Discount
    Route::resource('discounts', DiscountController::class)->except('show', 'edit', 'update');
    Route::delete('/discounts', [DiscountController::class, 'discountDeleteAll'])->name('discounts.destroyAll');
    //Interface
    Route::get('/interface', [\App\Http\Controllers\Admin\InterfaceController::class, 'index'])->name('interface.index');
    //ADRESSES
    Route::resource('addresses', AddressesController::class)->except('show', 'edit', 'create');

});


//404
//Route::fallback(function () {
//
//        return '404 maaan';
//});


