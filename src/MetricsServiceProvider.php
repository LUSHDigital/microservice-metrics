<?php
/**
 * @file
 * Contains \LushDigital\MicroServiceCore\MicroServiceServiceProvider;
 */

namespace LushDigital\MicroServiceCore;

use Illuminate\Support\ServiceProvider;
use LushDigital\MicroServiceMetrics\Http\Controllers\MetricsController;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Adapter;
use Prometheus\Storage\Redis;

/**
 * Service provider for core Micro Service functionality.
 *
 * @package LushDigital\MicroServiceCore
 */
class MetricsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Add our package routes.
        require_once __DIR__ . '/Http/routes.php';


        $this->app->bind(Adapter::class, function ($app) {
            return new Redis(['host' => env('REDIS_HOST')]);
        });

        $this->app->singleton(CollectorRegistry::class, function ($app) {
            return new CollectorRegistry($this->app->make(Adapter::class));
        });

        // Let Laravel Ioc Container know about our Controller
        $this->app->make(MetricsController::class);
    }
}