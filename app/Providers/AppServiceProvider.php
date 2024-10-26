<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::define('superadmin', function (User $user) {
            return $user->role === 'superadmin';
        });
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin' || $user->role === 'superadmin';
        });
    }
}
