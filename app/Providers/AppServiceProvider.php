<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
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
        view()->composer('*', function ($view) {
            $view->with('setting', Setting::first());
        });
        view()->composer('*', function ($view) {
            $view->with('notifications', Auth::user()->notifications()->whereNull('read_at')->get());
        });
        view()->composer('*', function ($view) {
            $view->with('notificationCount', Auth::user()->notifications()->whereNull('read_at')->count());
        });
    }
}
