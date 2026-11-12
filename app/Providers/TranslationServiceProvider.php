<?php

namespace App\Providers;

use App\Services\Translation\GeminiTranslator;
use App\Services\Translation\MessageTranslator;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GeminiTranslator::class);
        $this->app->singleton(MessageTranslator::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
