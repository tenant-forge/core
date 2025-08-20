<?php

declare(strict_types=1);

namespace TenantForge\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TenantForge\Tests\Contracts\Slugable;

use function is_string;
use function sprintf;

final class MakeUniqueSlugAction
{
    /**
     * @param  class-string<Model>  $modelClass
     */
    public function handle(string $name, string $modelClass): string
    {

        $slug = Str::slug($name);
        $suffix = '';

        $model = $modelClass::query()
            ->where('slug', 'like', $slug.'%')
            ->orderBy('created_at', 'desc')
            ->first('slug');

        /** @phpstan-ignore-next-line  */
        if ($model instanceof Slugable && $model->hasAttribute('slug') && is_string($model->slug)) {
            $explodedSlug = explode('-', $model->slug);
            $lastSegment = (int) (end($explodedSlug));

            $suffix = sprintf('-%d', $lastSegment + 1);

        }

        return $slug.$suffix;

    }
}
