<?php

declare(strict_types=1);

namespace TenantForge\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use TenantForge\Settings\AppearanceSettings;
use TenantForge\Settings\AppSettings;

readonly class HandleBladeRequests
{
    public function __construct(
        private AppSettings $appSettings,
        private AppearanceSettings $appearanceSettings,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        View::share([
            'title' => $this->appSettings->name,
            'description' => $this->appSettings->about,
            'logo' => Storage::disk('public')->url($this->appearanceSettings->logo ?? ''),
            'darkLogo' => Storage::disk('public')->url($this->appearanceSettings->dark_logo ?? ''),
            'favicon' => Storage::disk('public')->url($this->appearanceSettings->favicon ?? ''),
        ]);

        return $next($request);
    }
}
