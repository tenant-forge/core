<?php

use function TenantForge\Core\source_path;

test('it return the source path', function () {
    $sourcePath = source_path();
    expect($sourcePath)->toBe(dirname(__DIR__, 2) . '/src');
});
