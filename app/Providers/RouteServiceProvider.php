<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->routes(function () {
            $this->registerApiRoutes();
            $this->registerWebRoutes();
            $this->registerSetupRoutes();
            $this->registerClientRoutes();
            $this->registerServiceRoutes();
            $this->registerReportRoutes();
            $this->registerDatatableRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Register routes for the API section.
     * @return void
     */
    protected function registerApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Register routes for the web section.
     * @return void
     */
    protected function registerWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Register routes for the setup section.
     * @return void
     */
    protected function registerSetupRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/setup.php'));
    }

    /**
     * Register routes for the client section.
     * @return void
     */
    protected function registerClientRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/client.php'));
    }

    /**
     * Register routes for the service section.
     * @return void
     */
    protected function registerServiceRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/service.php'));
    }

    /**
     * Register routes for the report section.
     * @return void
     */
    protected function registerReportRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/report.php'));
    }

    /**
     * Register routes for the datatable livewire section.
     * @return void
     */
    protected function registerDatatableRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/datatable.php'));
    }
}
