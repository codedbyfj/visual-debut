@php
    $tag = $block->settings->heading_level ?? 'h2';
    $isSectionTitle = $tag === 'h2';
@endphp

<div class="flex items-center gap-4">
    @if ($isSectionTitle)
        <div class="h-8 w-1.5 bg-[#E32E2E] rounded-full"></div>
    @endif

    <x-shop::text-block :block="$block" :tag="$tag"
        class="!font-black !uppercase !tracking-tight !text-[#1A202C] {{ $isSectionTitle ? 'text-2xl' : '' }}"
        :additionalAttributes="$block->liveUpdate()->text('text')">
        {{ $block->settings->text }}
    </x-shop::text-block>
</div>
