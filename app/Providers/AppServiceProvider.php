<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $unreadNotifications = DB::table('notifications')
                    ->where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $view->with('unreadNotifications', $unreadNotifications);
            }
        });
    }
}
