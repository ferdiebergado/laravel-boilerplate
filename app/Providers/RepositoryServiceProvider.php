<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // UserRepository
        $this->app->bind(
            "App\\Interfaces\\UserRepositoryInterface",
            "App\\Repositories\\UserRepository"
        );

        $this->app->bind(
            "App\\Interfaces\\RoleRepositoryInterface",
            "App\\Repositories\\RoleRepository"
        );

        $this->app->bind(
            "App\\Interfaces\\PermissionRepositoryInterface",
            "App\\Repositories\\PermissionRepository"
        );

        $this->app->bind(
            "App\\Interfaces\\LoginRepositoryInterface",
            "App\\Repositories\\LoginRepository"
        );
    }
}
