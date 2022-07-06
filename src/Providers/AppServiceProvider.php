<?php

namespace Tperrelli\Encrypt\Providers;

use Tperrelli\Encrypt\Encrypt;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('encrypt', function($app) {

            $key    = Config::get('decrypt.key');
            $cipher = Config::get('decrypt.cipher');

            return new Encrypt($key, $cipher);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {

    }

    /**
     * Publish config file
     *
     */
    public function publishConfig()
    {   
        $this->publishes([
            __DIR__ . '/../../config/decrypt.php' => config_path('decrypt.php'),
       ]);
    }
}
