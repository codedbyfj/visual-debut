@props([
    'label' => null,
    'value' => 1,
    'min' => 0,
])

@php
    $props = ['value' => intval($value), 'min' => $min];
@endphp

<div x-data x-number-input="@js($props)"
    {{ $attributes->merge(['class' => 'flex items-center space-x-5']) }}>
    @if ($label)
        <label x-input-number:label class="text-sm font-semibold tracking-tight text-on-background/80">
            {{ $label }}
        </label>
    @endif
    <div
        class="focus-within:ring-primary/30 flex items-center overflow-hidden rounded-[--radius-md] border border-on-background/10 bg-surface shadow-sm focus-within:ring-4 transition-all duration-200">
        <button x-number-input:decrement-trigger
            class="hover:bg-background/50 hover:text-primary disabled:opacity-30 flex h-10 w-10 items-center justify-center transition-all disabled:cursor-not-allowed"
            type="button">
            <x-lucide-minus class="h-4 w-4" />
        </button>

        <input x-number-input:input
            class="w-12 appearance-none border-x border-on-background/5 bg-transparent py-2 text-center text-sm font-bold focus:outline-none">

        <button x-number-input:increment-trigger
            class="hover:bg-background/50 hover:text-primary disabled:opacity-30 flex h-10 w-10 items-center justify-center transition-all disabled:cursor-not-allowed"
            type="button">
            <x-lucide-plus class="h-4 w-4" />
        </button>
    </div>
</div>
