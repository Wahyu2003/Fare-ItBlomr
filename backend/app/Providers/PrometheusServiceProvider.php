<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\Redis as RedisStorage;
use Illuminate\Support\Facades\Route;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CollectorRegistry::class, function () {
            $adapter = new RedisStorage([
                'host' => 'redis',
                'port' => 6379,
                'persistent_connections' => false,
            ]);
            return new CollectorRegistry($adapter);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Tambahkan route /metrics untuk Prometheus scrape
        Route::get('/metrics', function () {
            $registry = app(CollectorRegistry::class);
            $renderer = new RenderTextFormat();
            $metrics = $registry->getMetricFamilySamples();

            return response(
                $renderer->render($metrics),
                200,
                ['Content-Type' => RenderTextFormat::MIME_TYPE]
            );
        });
    }
}
