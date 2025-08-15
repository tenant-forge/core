<?php

use Illuminate\Support\Facades\File;

function cleanup(): void
{

    $panelsPath = app_path('Providers/Filament');

    if (File::isDirectory($panelsPath)) {
        File::deleteDirectory($panelsPath);
    }

    $stubsPath = base_path('stubs');

    if (File::isDirectory($stubsPath)) {
        File::deleteDirectory($stubsPath);
    }

}

beforeEach(fn () => cleanup());
afterEach(fn () => cleanup());

it('creates a new central panel file', function (): void {

    $panelName = 'CentralPanelServiceProvider';

    $exitCode = Artisan::call(
        command: 'tenantforge:make-central-panel',
        parameters: ['name' => $panelName]
    );

    expect($exitCode)
        ->toBe(0);

    $appPath = app_path("Providers/Filament/{$panelName}.php");

    $expectedPath = app_path("Providers/Filament/{$panelName}.php");
    expect(File::exists($expectedPath))
        ->toBeTrue();

});
