<?php
//Admin
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\InterfaceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RolesPermissions\PermissionController;
use App\Http\Controllers\Admin\RolesPermissions\RoleController;
use App\Http\Controllers\Admin\RolesPermissions\RolePermissionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
//
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BasketItemController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
//Home
use App\Http\Controllers\Home\BookmarkController as HomeBookmarkController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\OrderController as HomeOrderController;
use App\Http\Controllers\Home\UserController as HomeUserController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
//
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;




//SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('live.search');

//Автор
Route::get('/authors/{author:slug?}', [AuthorController::class, 'index'])->name('authors.index');

//КНИГИ
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book:slug}', [BookController::class, 'show'])->name('books.book');


//------------------------------------------------CATEGORIES------------------------------------------------
Route::get('/categories/{category:slug?}',[CategoryController::class,'show'])->name('categories.show');
Route::get('/categories-special/{slug}',[CategoryController::class,'specialCategories'])->whereIn('slug', ['bestsellers', 'sales', 'newest'])->name('specialCategories.show');

//------------------------------------------------BASKET------------------------------------------------
Route::prefix('basket')->group(function () {
    Route::get('/', [BasketController::class, 'index'])->name('basket.index');
    Route::post('/make-order', [BasketController::class, 'makeOrder'])->name('basket.order');
    Route::post('/basket-items/book/increase', [BasketItemController::class, 'increase'])->name('basket-item.increase');
    Route::post('/basket-items/book/decrease', [BasketItemController::class, 'decrease'])->name('basket-item.decrease');
    Route::delete('/basket-items/book/{book}', [BasketItemController::class, 'deleteAllByBook'])->name('basket-item.deleteAll');
});
//------------------------------------------------PROFILE------------------------------------------------
Route::name('home.')->prefix('home')->middleware('role:user|admin')->group(function () {
    //BOOKMARKS
    Route::get('/bookmarks', [HomeBookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [HomeBookmarkController::class, 'store'])->name('bookmarks.store');
    //COMMENTS
    Route::resource('/comments', HomeCommentController::class)->only(['index','update','destroy']);
    //ORDERS
    Route::get('/orders', [HomeOrderController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [HomeOrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [HomeOrderController::class, 'destroy'])->name('orders.destroy');
    //USER INFO
    Route::get('/info', [HomeUserController::class, 'infoUser'])->name('info');
    Route::patch('/info', [HomeUserController::class, 'infoUserUpdate'])->name('info.update');
    Route::delete('/user',[HomeController::class,'userDelete'])->name('user.destroy');
});

//------------------------------------------------Comments------------------------------------------------
Route::resource('books.comments', CommentController::class)->only(['destroy', 'store', 'update']);


//------------------------------------------------ADMIN-PANEL--------------------------------------------//
Route::name('admin.')->prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    //Roles and Permission
    Route::get('/roles-permission', [RolePermissionController::class, 'index'])->name('roles.permissions.index');
    Route::put('/role/{role}/permissions', [RolePermissionController::class, 'updatePermissionsForRole'])->name('roles.permissions.update');
    Route::put('/role/user/{user}', [RolePermissionController::class, 'updateRoleForUser'])->name('roles.users.update');
    //Permission
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    //ROLES
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    //Books
    Route::resource('books', AdminBookController::class)->except('show', 'edit');
    //Categories
    Route::resource('categories', AdminCategoryController::class);
    //Users
    Route::resource('users', AdminUserController::class);
    //Orders
    Route::get('/orders', [AdminOrderController::class, 'orders'])->name('orders.index');
    Route::get('/orders-history', [AdminOrderController::class, 'orderHistory'])->name('orders.history');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'addStatusOrder'])->name('orders.status.update');
    Route::get('/orders/{order}', [AdminOrderController::class, 'aboutOrderAdmin'])->name('orders.show');
    //AUTHORS
    Route::resource('authors', AdminAuthorController::class);
    //DISCOUNT
    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
    Route::post('/discounts/book', [DiscountController::class, 'discountForBook'])->name('discounts.book');
    Route::post('/discounts/author', [DiscountController::class, 'discountForAuthor'])->name('discounts.author');
    Route::delete('/discounts/{book}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
    Route::delete('/discounts', [DiscountController::class, 'discountDeleteAll'])->name('discounts.destroyAll');
    //Interface
    Route::get('/interfaces', [InterfaceController::class, 'index'])->name('interfaces.index');
    Route::post('/interfaces/slides', [InterfaceController::class, 'store'])->name('interfaces.slides.store');
    Route::delete('/interfaces/slides/{slide}', [InterfaceController::class, 'destroy'])->name('interfaces.slides.destroy');
    //ADDRESSED
    Route::resource('addresses', AddressController::class)->except('show', 'edit', 'create');
    Route::get('/addresses-deleted', [AddressController::class, 'addressesDeleted'])->name('addresses.deleted');
    Route::put('/addresses-deleted/{address}/restore', [AddressController::class, 'addressesRestore'])->name('addresses.restore')->withTrashed();
});


//404
//Route::fallback(function () {
//
//        return '404 maaan';
//});


