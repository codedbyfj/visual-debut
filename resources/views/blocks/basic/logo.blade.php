@php
    $logoDesktop = $block->settings->logo_image ?: $theme->settings->logo_desktop;
    $logoMobile = $block->settings->mobile_logo_image ?: $theme->settings->logo_mobile;
    $logoText = $block->settings->logo_text ?: config('app.name');

    $logoHeight = $block->settings->logo_height ?? 36;
    $logoWidth = $block->settings->logo_width;

    // Handle responsive height if available
    $heightData = \BagistoPlus\VisualDebut\Tailwind::buildResponsiveStyleFor(
        value: $logoHeight,
        prefix: 'h',
        property: 'logo-height',
        unit: 'px',
    );

    // Handle responsive width if available
    $widthData = $logoWidth
        ? \BagistoPlus\VisualDebut\Tailwind::buildResponsiveStyleFor(
            value: $logoWidth,
            prefix: 'w',
            property: 'logo-width',
            unit: 'px',
        )
        : ['classes' => '', 'styles' => []];
@endphp

<div {{ $block->editor_attributes }} {{ $block->settings->color_scheme?->attributes() }} class="flex items-center">
    <a href="{{ url('/') }}" class="group flex items-center transition-all duration-300">
        @if ($logoDesktop)
            <span class="sr-only">{{ $logoText }}</span>

            <img src="{{ $logoDesktop }}" alt="{{ $logoText }}" @class([
                $heightData['classes'],
                $widthData['classes'],
                'w-auto' => !$logoWidth,
                'object-contain transition-transform group-hover:scale-105',
                'hidden sm:inline' => $logoMobile,
            ])
                style="height: var(--logo-height); width: {{ $logoWidth ? 'var(--logo-width)' : 'auto' }}; {{ implode(';', array_merge($heightData['styles'], $widthData['styles'])) }}" />

            @if ($logoMobile)
                <img src="{{ $logoMobile }}" alt="{{ $logoText }}" @class([
                    $heightData['classes'],
                    $widthData['classes'],
                    'w-auto' => !$logoWidth,
                    'object-contain sm:hidden transition-transform group-hover:scale-105',
                ])
                    style="height: var(--logo-height); width: {{ $logoWidth ? 'var(--logo-width)' : 'auto' }}; {{ implode(';', array_merge($heightData['styles'], $widthData['styles'])) }}" />
            @endif
        @elseif ($logo = core()->getCurrentChannel()->logo_url)
            <span class="sr-only">{{ $logoText }}</span>
            <img src="{{ $logo }}" alt="{{ $logoText }}" @class([
                $heightData['classes'],
                $widthData['classes'],
                'w-auto' => !$logoWidth,
                'object-contain transition-transform group-hover:scale-105',
            ])
                style="height: var(--logo-height); width: {{ $logoWidth ? 'var(--logo-width)' : 'auto' }}; {{ implode(';', array_merge($heightData['styles'], $widthData['styles'])) }}" />
        @else
            <span class="text-gradient text-3xl font-black tracking-tighter transition-all group-hover:opacity-80">
                {{ $logoText }}
            </span>
        @endif
    </a>
</div>
