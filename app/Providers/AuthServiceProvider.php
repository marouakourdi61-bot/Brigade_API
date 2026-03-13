<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use App\Models\Plat;
use App\Policies\PlatPolicy;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        // $this->registerPolicies();
    }
}
