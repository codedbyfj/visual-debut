@php
    $variant = $section->settings->variant ?? 'primary';
    $classes =
        [
            'primary' => 'bg-primary text-on-primary',
            'secondary' => 'bg-secondary text-on-secondary',
            'accent' => 'bg-accent text-on-accent',
            'neutral' => 'bg-neutral text-on-neutral',
        ][$section->settings->variant] ?? 'bg-primary text-on-primary';
@endphp

<div {{ $section->editor_attributes }} {{ $section->settings->scheme?->attributes() }}
    class="{{ $classes }} relative overflow-hidden py-2 text-center text-[11px] font-black uppercase tracking-[0.2em]"
    x-data="{ show: true }" x-show="show">
    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 opacity-30"></div>

    <div class="relative flex items-center justify-center gap-2">
        @if ($section->settings->link)
            <a href="{{ $section->settings->link }}" class="hover:opacity-80 transition-opacity"
                {{ $section->liveUpdate()->text('text')->attr('link', 'href') }}>
                {{ $section->settings->text }}
            </a>
            <x-lucide-arrow-right class="h-3 w-3" />
        @else
            <p class="announcement-text" {{ $section->liveUpdate()->text('text') }}>
                {{ $section->settings->text }}
            </p>
        @endif
    </div>

    <button class="absolute right-2 top-1/2 -translate-y-1/2 p-2 hover:opacity-75 transition-opacity" aria-label="Close"
        x-on:click="show = false">
        <x-lucide-x class="h-3.5 w-3.5" />
    </button>
</div>
