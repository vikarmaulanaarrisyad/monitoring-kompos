<?php

namespace App\Providers;

use App\Models\Setting;
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
        view()->composer('*', function ($view) {
            $view->with('setting', Setting::first());
        });
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = $user->notifications()->whereNull('read_at')->orderBy('created_at', 'DESC')->limit(5)->get();
                $notificationCount = $user->notifications()->whereNull('read_at')->count();

                $view->with('notifications', $notifications);
                $view->with('notificationCount', $notificationCount);
            }
        });
        // view()->composer('*', function ($view) {
        //     $view->with('notifications', Auth::user()->notifications()->whereNull('read_at')->where('created_at','DESC')->limit(5)->get());
        // });
        // view()->composer('*', function ($view) {
        //     $view->with('notificationCount', Auth::user()->notifications()->whereNull('read_at')->where('created_at','DESC')->limit(5)->count());
        // });
    }
}
