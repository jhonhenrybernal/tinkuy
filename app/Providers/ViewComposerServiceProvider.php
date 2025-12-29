<?php

namespace App\Providers;

use App\View\Composers\AdminLanguageComposer;
use App\View\Composers\StoreMenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
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
        View::composer('themes.*', StoreMenuComposer::class);
        View::composer('admin.*', AdminLanguageComposer::class);
    }
}
