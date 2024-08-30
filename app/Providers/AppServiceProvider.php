<?php

namespace App\Providers;

use App\Models\Basket;
use App\Models\Basket_items;
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
            $basket = Basket::where(['user_id' => Auth::id()])->first();
            $bookInBasket = Basket_items::where(['basket_id' => $basket->id])->count();
            $view->with('bookInBasket', $bookInBasket);
        });
    }
}
