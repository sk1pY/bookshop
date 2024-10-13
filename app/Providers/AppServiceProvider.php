<?php

namespace App\Providers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::guard()->check()) {
                $basket = Basket::where(['user_id' => Auth::id()])->first();
                if (!$basket) {
                    $bookInBasket = 0;
                } else {
                    $bookInBasket = BasketItem::where(['basket_id' => $basket->id])->pluck('quantity')->toArray();
                    $bookInBasket = array_sum($bookInBasket);
                }

                $view->with('bookInBasket', $bookInBasket);

            }

        });
        View::composer('*', function ($view) {
            if (Auth::guard()->check()) {
                $countOrders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->count();
                $view->with('countOrders', $countOrders);
            }
        });
        View::composer('*', function ($view) {
            if (Auth::guard()->check()) {

                $countOrdersforUser = Order::where('user_id', Auth::user()->id)->whereIn('status', ['Готов к выдаче'])->count();
                $view->with('countOrdersforUser', $countOrdersforUser);
            }
        });
        View::composer('header.nav', function ($view) {
            if (Auth::guard()->check()) {
                $notifOrders = Order::where(['status' => 'Готов к выдаче', 'user_id' => Auth::user()->id])->pluck('id')->toArray();
                $categories = Category::all();

                $view->with('notifOrders', $notifOrders)
                    ->with('categories', $categories);
            }
        });
    }
}
