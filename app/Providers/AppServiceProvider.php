<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

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
        // Fix storage URLs for Windows/Laragon environment
        Storage::disk('public')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return url('storage/' . $path);
        });
    }
}
