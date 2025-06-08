<?php

namespace App\Providers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('basket', function () {
            return Auth::check() ? Basket::firstOrCreate(['user_id' => Auth::id()]) : null;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('check-bought-book', function (User $user, Book $book) {
            return $user->orders()->whereHas('order_items', function ($query) use ($book) {
                $query->where('book_id', $book->id);
            })->exists();
        });

        Carbon::setLocale('ru');
        Route::pattern('id', '[0-9]+');
        Route::pattern('', '[0-9]+');

        View::composer('layouts.admin', function ($view) {
            $countOrders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->count();
            $view->with('countOrders', $countOrders);
        });

        View::composer('*', function ($view) {

            if (Auth::guard()->check()) {
                $basket = app('basket');
                $booksInBasketArray = $basket->basket_items()->pluck('book_id')->toArray();
                $booksInBasketQuantity = $basket->basket_items()->pluck('quantity')->sum();

                $view->with([
                    'booksInBasketArray' => $booksInBasketArray,
                    'bookInBasketQuantity' => $booksInBasketQuantity,
                ]);
            } else {
                $books = collect(session()->get('books', []));
                $booksInBasketArray = $books->pluck('id')->toArray();
                $bookInBasketQuantity = $books->pluck('quantity')->sum();
                $view->with([
                    'booksInBasketArray' => $booksInBasketArray,
                    'bookInBasketQuantity' => $bookInBasketQuantity,
                ]);

            }
        });




        View::composer('*', function ($view) {
            if (Auth::guard()->check()) {
                $bookmarkBookUser = Bookmark::where('user_id', Auth::id())->pluck('book_id')->toArray();
                $countOrdersforUser = Auth::user()->orders()->where('status', 'Готов к выдаче')->count();
            } else {
                $bookmarkBookUser = [];
                $countOrdersforUser = 0;
            }
            $view->with(['countOrdersforUser' => $countOrdersforUser, 'bookmarkBookUser' => $bookmarkBookUser]);

        });

        View::composer('partials.nav', function ($view) {
            if (Auth::guard()->check()) {
                $notifOrders = Auth::user()->orders()->where('status', 'Готов к выдаче')->pluck('id')->all();
                $view->with('notifOrders', $notifOrders);
            }
            $categories = Category::all();

            $view->with('categories', $categories);

        });
    }
}
