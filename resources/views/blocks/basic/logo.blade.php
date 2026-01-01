@php
    $logoDesktop = $block->settings->logo_image ?: $theme->settings->logo_desktop;
    $logoMobile = $block->settings->mobile_logo_image ?: $theme->settings->logo_mobile;
    $logoText = $block->settings->logo_text ?: config('app.name');

    $logoHeight = $block->settings->logo_height ?? 36;

    // Handle responsive height if available
    $logoData = \BagistoPlus\VisualDebut\Tailwind::buildResponsiveStyleFor(
        value: $logoHeight,
        prefix: 'h',
        property: 'logo-height',
        unit: 'px',
    );
@endphp

<div {{ $block->editor_attributes }} {{ $block->settings->color_scheme?->attributes() }} class="flex items-center">
    <a href="{{ url('/') }}" class="group flex items-center transition-all duration-300">
        @if ($logoDesktop)
            <span class="sr-only">{{ $logoText }}</span>

            <img src="{{ $logoDesktop }}" alt="{{ $logoText }}" @class([
                $logoData['classes'],
                'w-auto object-contain transition-transform group-hover:scale-105',
                'hidden sm:inline' => $logoMobile,
            ])
                style="{{ implode(';', $logoData['styles']) }}" />

            @if ($logoMobile)
                <img src="{{ $logoMobile }}" alt="{{ $logoText }}" @class([
                    $logoData['classes'],
                    'w-auto object-contain sm:hidden transition-transform group-hover:scale-105',
                ])
                    style="{{ implode(';', $logoData['styles']) }}" />
            @endif
        @elseif ($logo = core()->getCurrentChannel()->logo_url)
            <span class="sr-only">{{ $logoText }}</span>
            <img src="{{ $logo }}" alt="{{ $logoText }}" @class([
                $logoData['classes'],
                'w-auto object-contain transition-transform group-hover:scale-105',
            ])
                style="{{ implode(';', $logoData['styles']) }}" />
        @else
            <span class="text-gradient text-3xl font-black tracking-tighter transition-all group-hover:opacity-80">
                {{ $logoText }}
            </span>
        @endif
    </a>
</div>
