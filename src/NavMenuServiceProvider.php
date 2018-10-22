<?php
namespace Laravelcity\NavMenu;

use Illuminate\Support\ServiceProvider;

class NavMenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // routes
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // views
        $this->loadViewsFrom(__DIR__.'/Views', 'NavMenu');
        //trans
        $this->loadTranslationsFrom(__DIR__.'/Lang/', 'NavMenu');

        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/NavMenu'),
        ],'navview');


        //migrations

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //configs
        $this->mergeConfigFrom(
            __DIR__.'/Configs/navmenu.php', 'navmenu'
        );
        $this->publishes([
            __DIR__.'/Configs/navmenu.php' => config_path('navmenu.php'),
        ],'navconfig');

        $this->publishes([
            __DIR__.'/Lang/' => resource_path('lang/vendor/navmenu'),
        ]);


        require_once __DIR__ . '/helper.php';

    }
}
