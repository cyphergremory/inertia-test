<?php

namespace App\Providers;

use App\Core\CustomPaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); 
        
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new CustomPaginator(...array_values($values));
        });

        
    }

  
}
