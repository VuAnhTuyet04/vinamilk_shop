<?php

namespace App\Providers;

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
   public function boot()
{
    // Chia sẻ danh mục và sản phẩm bán chạy cho tất cả các view của client
    view()->composer('client.*', function ($view) {
        $view->with('categories', \App\Models\Category::all());
        
    });
}
}
