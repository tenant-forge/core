<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use TenantForge\Filament\Forms\Components\Builder\SectionBuilder;
use TenantForge\Filament\Forms\Components\Builder\TextInputBuilder;

/**
 * @param  array<int|string, mixed>  $array
 * @return Collection<int|string, mixed>
 */
function recursive_collect(array $array, null|string|int $parentKey = ''): Collection
{
    $collection = collect($array);

    foreach ($collection as $key => $value) {

        if (is_array($value)) {
            $value['path'] = $newKey = ! empty($parentKey) ? $parentKey.'.'.$key : $key;
            $collection[$key] = recursive_collect($value, $newKey);
        }
    }

    return $collection;
}

test('it can add a child element to a root element', function (): void {

    $customFields = [
        $firstId = '89309bbd-1054-48f7-96df-52c54d7a7e86' => [
            'component' => SectionBuilder::$type,
            'name' => 'SEO',
            'configuration' => [
                'label' => 'SEO',
                'description' => 'This is the description',
                'children' => [],
            ],
        ],
        $secondId = '11162bdc-717e-4046-8f90-e10d26fba181' => [
            'component' => SectionBuilder::$type,
            'name' => 'localization',
            'configuration' => [
                'label' => 'Localization',
                'description' => 'This is the description of the localization',
                'children' => [
                    $thirdId = '46c036e6-cb8d-4645-a47a-9058caabc32d' => [
                        'component' => SectionBuilder::$type,
                        'name' => 'Child Section',
                        'configuration' => [
                            'label' => 'SEO',
                            'description' => 'This is the description',
                            'children' => [],
                        ],
                    ],
                    '6a243049-6f07-4cc3-9a0e-7d790479602d' => [
                        'component' => TextInputBuilder::$type,
                        'name' => 'city',
                        'configuration' => [
                            'label' => 'City',
                            'description' => 'Please enter the city name',
                        ],
                    ],
                ],
            ],
        ],
    ];

    $customFieldsCollection = recursive_collect($customFields);

    expect(Arr::get($customFields, '11162bdc-717e-4046-8f90-e10d26fba181.configuration.children.6a243049-6f07-4cc3-9a0e-7d790479602d.name'))
        ->toBe('city');

    data_set($customFields, '11162bdc-717e-4046-8f90-e10d26fba181.configuration.children.6a243049-6f07-4cc3-9a0e-7d790479602d.name', 'new name');

    expect(Arr::get($customFields, '11162bdc-717e-4046-8f90-e10d26fba181.configuration.children.6a243049-6f07-4cc3-9a0e-7d790479602d.name'))
        ->toBe('new name');

    $newKey = Str::uuid()->toString();

    Arr::push($customFields, '11162bdc-717e-4046-8f90-e10d26fba181.configuration.children.'.$newKey, [
        'component' => TextInputBuilder::$type,
        'name' => 'country',
        'configuration' => [
            'label' => 'Country',
            'col_span' => 'full',
        ],
    ]);

    expect(array_keys(Arr::get($customFields, '11162bdc-717e-4046-8f90-e10d26fba181.configuration.children')))
        ->toContain($newKey);

});
