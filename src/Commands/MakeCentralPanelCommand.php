<?php

declare(strict_types=1);

namespace TenantForge\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

final class MakeCentralPanelCommand extends GeneratorCommand
{
    protected $name = 'tenantforge:make-central-panel';

    protected $description = 'Create a new central panel service provider';

    protected $type = 'CentralPanelServiceProvider';

    public function handle(): ?bool
    {

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        return parent::handle();

    }

    protected function getNameInput(): string
    {
        return $this->argument('name');
    }

    protected function getDefaultNamespace($rootNamespace): string // @pest-ignore-type
    {
        return $rootNamespace.'\Providers\Filament';
    }

    protected function getPath($name): string // @pest-ignore-type
    {

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return app_path(str_replace('\\', '/', $name).'.php');
    }

    protected function getStub(): string
    {
        return $this->resolveStubPath('stubs/central-panel.stub');
    }

    private function resolveStubPath(string $stub): string
    {
        $basePath = $this->laravel->basePath(mb_trim($stub, '/'));

        return file_exists($basePath)
            ? $basePath
            : __DIR__.'/../../'.$stub;
    }
}
