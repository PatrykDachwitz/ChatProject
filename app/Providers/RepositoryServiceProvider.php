<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\NotificationRepository as NotificationRepositoryInterface;
use App\Repository\Eloquent\NotificationRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
    }
}
