<?php

namespace App\Providers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Carbon::setLocale('ru');
        Route::pattern('id','[0-9]+');
        Route::pattern('','[0-9]+');

//        View::composer('*', function ($view) {
//            if (Auth::guard()->check()) {
//                $basket = Basket::where(['user_id' => Auth::id()])->first();
//                if (!$basket) {
//                    $bookInBasket = 0;
//                } else {
//                    $bookInBasket = BasketItem::where(['basket_id' => $basket->id])->pluck('quantity')->toArray();
//                    $bookInBasket = array_sum($bookInBasket);
//                }
//
//                $view->with('bookInBasket', $bookInBasket);
//            }
//        });

        View::composer('*', function ($view) {
            if (Auth::guard()->check()) {
                //create basket after auth uuser
                $basket = Basket::firstOrCreate(['user_id' => Auth::id()])->first();

                $countOrders = Order::whereIn('status', ['Новый заказ', 'Готов к выдаче'])->count();
                $view->with([
                    'countOrders' => $countOrders,
                    'basket' => $basket
                ]);
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

                $view->with('notifOrders', $notifOrders);
            }
            $categories = Category::all();

            $view ->with('categories', $categories);

        });
    }
}
