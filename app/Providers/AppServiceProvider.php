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
        // Define Gates for Role-Based Access Control
        \Illuminate\Support\Facades\Gate::define('isSuperAdmin', function ($user) {
            return $user->role === 'super-admin';
        });

        \Illuminate\Support\Facades\Gate::define('isStaff', function ($user) {
            return in_array($user->role, ['super-admin', 'staff']);
        });

        \Illuminate\Support\Facades\Gate::define('isUser', function ($user) {
            return $user->role === 'user';
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('user', $user);
                $view->with('role', $user->role);
            }
        });
    }
}
