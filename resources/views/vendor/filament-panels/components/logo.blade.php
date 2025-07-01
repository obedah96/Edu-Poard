@php
    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = filament()->getBrandLogoHeight() ?? '1.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoClasses = fn (bool $isDarkMode): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo flex flex-col items-center space-y-1', // ← flex-col بدلاً من flex-row
        'dark:hidden' => $hasDarkModeBrandLogo && (! $isDarkMode),
        'hidden dark:flex' => $hasDarkModeBrandLogo && $isDarkMode,
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

@capture($content, $logo, $isDarkMode = false)
    <div {{ $attributes->class([$getLogoClasses($isDarkMode)]) }}>
        @if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
            <div style="{{ $logoStyles }}">
                {{ $logo }}
            </div>
        @elseif (filled($logo))
            <img
                alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
                src="{{ $logo }}"
                style="{{ $logoStyles }}"
            />
        @endif

        <span class="text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white">
            {{ $brandName }}
        </span>
    </div>
@endcapture

{{ $content($brandLogo) }}

@if ($hasDarkModeBrandLogo)
    {{ $content($darkModeBrandLogo, isDarkMode: true) }}
@endif
