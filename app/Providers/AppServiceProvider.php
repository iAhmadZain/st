<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProductCache;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ProductCache::class, function ($app) {
            return new ProductCache();
        });
    }

    public function boot()
    {
        //
    }
}
