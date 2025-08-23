<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;

use function config;
use function env;

final class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        config()->set('app.domain', env('APP_DOMAIN', 'localhost'));

        // Fix URL generation for development server port issues
        if (app()->environment(['local', 'testing'])) {
            $appUrl = env('APP_URL', 'http:/localhost:8000');

            // Force Laravel to use the correct APP_URL for all URL generation
            url()->forceRootUrl($appUrl);

            // Also fix asset URL generation
            if (str_contains($appUrl, ':8000')) {
                config(['app.url' => $appUrl]);
            }
        }
    }
}
