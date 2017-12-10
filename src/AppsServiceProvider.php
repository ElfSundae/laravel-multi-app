<?php

namespace ElfSundae\Laravel\Apps;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as Config;

class AppsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        (new MacroRegistrar)->registerMacros($this->app);

        $this->publishAssets();
    }

    /**
     * Publish assets from package.
     *
     * @return void
     */
    protected function publishAssets()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/apps.php' => config_path('apps.php'),
        ], 'laravel-apps');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupAssets();

        $this->registerAppManager();

        $this->setupConfiguration();
    }

    /**
     * Setup package assets.
     *
     * @return void
     */
    protected function setupAssets()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/apps.php', 'apps');
    }

    /**
     * Register app manager singleton.
     *
     * @return void
     */
    protected function registerAppManager()
    {
        $this->app->singleton('apps', function ($app) {
            return new AppManager($app);
        });

        $this->app->alias('apps', AppManager::class);
    }

    /**
     * Setup application configurations.
     *
     * @return void
     */
    protected function setupConfiguration()
    {
        $this->app->booting(function ($app) {
            $config = $app['config'];

            if (! $app->configurationIsCached()) {
                $config->set($config->get('apps.config.default', []));
            }

            if ($appId = $app['apps']->id()) {
                $config->set($config->get('apps.config.'.$appId, []));
            }
        });
    }
}
