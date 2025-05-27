<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Prometheus\RenderTextFormat;
use Illuminate\Support\Facades\Route;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Daftarkan registry ke service container
        $this->app->singleton(CollectorRegistry::class, function () {
            $adapter = new InMemory(); // Ganti ke Redis jika perlu
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
