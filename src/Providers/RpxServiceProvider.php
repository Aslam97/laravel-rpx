<?php

namespace Aslam\Rpx\Providers;

use Aslam\Rpx\Rpx;
use Illuminate\Support\ServiceProvider;

class RpxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../../config/rpx.php' => config_path('rpx.php'),
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/rpx.php', 'rpx');

        $this->app->singleton('Rpx', function () {
            return new Rpx();
        });
    }
}
