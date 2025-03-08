<?php

namespace App\Providers;

use Carbon\Carbon;
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
        Carbon::macro('subPeriod', function ($period) {
            switch ($period) {
                case 'week':
                    return $this->subWeek();
                case 'month':
                    return $this->subMonth();
                case 'quarter':
                    return $this->subQuarter();
                case 'year':
                    return $this->subYear();
                default:
                    return $this->subWeek();
            }
        });
    }
}
