<?php

namespace App\Providers;

use App\Interface\AuthInterface;
use App\Interface\ChatbotInterface;
use App\Repository\AuthRepository;
use App\Repository\ChatbotRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(ChatbotInterface::class, ChatbotRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
