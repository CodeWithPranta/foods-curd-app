<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
        Cache::extend('file_tagged', function ($app) {
            return Cache::repository(new \Illuminate\Cache\FileStore(
                $app['files'],
                storage_path('framework/cache/data')
            ))->tags();
        });
    }
}
