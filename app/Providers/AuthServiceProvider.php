<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // vos policies…
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
