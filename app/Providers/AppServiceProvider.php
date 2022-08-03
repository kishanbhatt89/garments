<?php

namespace App\Providers;

use App\Http\Resources\Api\v1\StateResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;    

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
        StateResource::withoutWrapping();
        Paginator::useBootstrap();
    }
}
