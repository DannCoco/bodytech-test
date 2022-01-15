<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\EloquentProductRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\EloquentCartRepository;

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
