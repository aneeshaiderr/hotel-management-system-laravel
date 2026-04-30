<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $userGroups = ['user', 'super-admin']; // Forcing super-admin for now as requested
                if ($user->role === 'staff') {
                    $userGroups[] = 'staff';
                }
                $view->with('userGroups', $userGroups);
                $view->with('user', $user);
            }
        });

    }
}
