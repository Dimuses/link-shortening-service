<?php

namespace App\Providers;

use App\Repositories\ShortLinkMysqlRepository;
use App\Repositories\ShortLinkRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ShortLinkRepositoryInterface::class, ShortLinkMysqlRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
