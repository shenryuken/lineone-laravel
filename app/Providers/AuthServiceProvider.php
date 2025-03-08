<?php

namespace App\Providers;

use App\Models\Kyc;
use App\Policies\KycPolicy;
use App\Models\Kyb;
use App\Policies\KybPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Kyc::class => KycPolicy::class,
        Kyb::class => KybPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // You can add any custom Gates here if needed
    }
}

