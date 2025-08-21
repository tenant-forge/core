@props([
    'appName' => config()->string('app.name'),
    'heading' => null,
    'subheading' => null
])

<div class="flex overflow-hidden transition opacity-100 duration-750 starting:opacity-0 starting:translate-y-2">

    <div class="w-full md:w-6/12 py-16 px-6 md:min-w-[600px]">
        <div class="flex flex-col items-center max-h-screen overflow-y-auto">
            <div class="w-full max-w-[512px] p-1">

                <div class="text-3xl font-bold mb-12">
                    {{ $appName }}
                </div>

                <div class="mb-8">

                    @if ($heading)
                        <h2 class="text-xl font-semibold">
                            {{ $heading }}
                        </h2>
                    @endif

                    @if ($subheading)
                        <p class="text-gray-400">
                            {{ $subheading }}
                        </p>
                    @endif
                </div>

                {{$slot}}
            </div>
        </div>

    </div>

    <div class="hidden md:block md:w-6/12">
        Hello
    </div>

    <x-filament-actions::modals />

</div>

