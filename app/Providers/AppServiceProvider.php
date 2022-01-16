<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\EloquentProductRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\EloquentCartRepository;
use App\Repositories\CartDetail\CartDetailRepository;
use App\Repositories\CartDetail\EloquentCartDetailRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\EloquentOrderRepository;
use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\OrderDetail\EloquentOrderDetailRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(CartRepository::class, EloquentCartRepository::class);
        $this->app->bind(CartDetailRepository::class, EloquentCartDetailRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(OrderDetailRepository::class, EloquentOrderDetailRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
