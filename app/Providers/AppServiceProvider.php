<?php

namespace App\Providers;

use App\Models\Basket;
use App\Models\BasketItem;
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
                if(!$basket){
                    $bookInBasket = 0;
                }else{
                    $bookInBasket = BasketItem::where(['basket_id' => $basket->id])->pluck('quantity')->toArray();
                    $bookInBasket = array_sum($bookInBasket);
                }

                $view->with('bookInBasket', $bookInBasket);

            }

        });
    }
}
