<?php

namespace AndyJessop\LaravelFacebook;

use Illuminate\Support\ServiceProvider;

class LaravelFacebookServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-facebook.php' => config_path('laravel-facebook.php'),
        ], 'config');
    }

    /**
     * Register the service providers.
     *
     * @return void
     */
    public function register()
    {
        // Main Service
        $this->app->bind('AndyJessop\LaravelFacebook\LaravelFacebook', function ($app) {
            $config = $app['config']->get('laravel-facebook.facebook_config');

            if (! isset($config['persistent_data_handler'])) {
                $config['persistent_data_handler'] = new LaravelPersistentDataHandler($app['session.store']);
            }

            if (! isset($config['url_detection_handler'])) {
                $config['url_detection_handler'] = new LaravelUrlDetectionHandler($app['url']);
            }

            return new LaravelFacebook($app['config'], $app['url'], $config);
        });
    }
}
