<?php

declare(strict_types=1);

namespace TenantForge\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use TenantForge\Settings\AppSettings;

class HandleBladeRequests
{
    public function __construct(
        private readonly AppSettings $appSettings
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
            'logo' => Storage::disk('public')->url($this->appSettings->logo ?? ''),
            'darkLogo' => Storage::disk('public')->url($this->appSettings->dark_logo ?? ''),
        ]);

        return $next($request);
    }
}
