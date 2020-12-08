<?php

namespace App\Providers;

use App\Models\PerformanceScore;
use App\Models\WspReporting;
use App\Observers\PerformanceScoreObserver;
use App\Observers\WspReportingObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        PerformanceScore::observe(PerformanceScoreObserver::class);
        WspReporting::observe(WspReportingObserver::class);
    }
}
