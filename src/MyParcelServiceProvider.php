<?php

namespace Mvdnbrk\MyParcel;

use Illuminate\Support\ServiceProvider;

class MyParcelServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/myparcel.php' => config_path('myparcel.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/myparcel.php', 'myparcel');

        $this->app->singleton(Client::class, function () {
            return (new Client())->setApiKey(config('myparcel.key'));
        });

        $this->app->alias(Client::class, 'myparcel');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class, 'myparcel'];
    }
}
