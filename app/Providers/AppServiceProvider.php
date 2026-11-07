<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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

        // @assetv('assets/css/app.css') -> asset URL + ?v=<file mtime>, so browsers never keep stale CSS/JS.
        Blade::directive('assetv', fn (string $path): string => "<?php echo e(asset({$path}).'?v='.(@filemtime(public_path({$path})) ?: 0)); ?>");
    }
}
