<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
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
        Paginator::useBootstrapFour();

        // Separate buckets: browsing dates (slots) must never use up the budget of booking itself.
        RateLimiter::for('reservation-submit', fn (Request $request) => Limit::perMinute(10)->by('reservation-submit|'.$request->ip()));
        RateLimiter::for('newsletter-subscribe', fn (Request $request) => Limit::perMinute(5)->by('newsletter-subscribe|'.$request->ip()));
        RateLimiter::for('reservation-slots', fn (Request $request) => Limit::perMinute(60)->by('reservation-slots|'.$request->ip()));

        // @assetv('assets/css/app.css') -> asset URL + ?v=<file mtime>, so browsers never keep stale CSS/JS.
        Blade::directive('assetv', fn (string $path): string => "<?php echo e(asset({$path}).'?v='.(@filemtime(public_path({$path})) ?: 0)); ?>");
    }
}
