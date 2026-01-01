@props([
    'label' => null,
    'value' => 1,
    'min' => 0,
])

@php
    $props = ['value' => intval($value), 'min' => $min];
@endphp

<div x-data x-number-input="@js($props)"
    {{ $attributes->merge(['class' => 'flex items-center gap-4']) }}>
    @if ($label)
        <label x-input-number:label class="text-xs font-black uppercase tracking-widest text-on-background/40">
            {{ $label }}
        </label>
    @endif
    <div
        class="focus-within:border-primary/50 flex items-center overflow-hidden rounded-[--radius-full] border border-on-background/10 bg-surface shadow-sm transition-all duration-300">
        <button x-number-input:decrement-trigger
            class="group hover:bg-primary/10 hover:text-primary disabled:opacity-20 flex h-11 w-11 items-center justify-center transition-all disabled:cursor-not-allowed"
            type="button">
            <x-lucide-minus class="h-4 w-4 transition-transform group-active:scale-75" />
        </button>

        <input x-number-input:input
            class="w-14 appearance-none border-none bg-transparent py-2 text-center text-sm font-black focus:outline-none focus:ring-0">

        <button x-number-input:increment-trigger
            class="group hover:bg-primary/10 hover:text-primary disabled:opacity-20 flex h-11 w-11 items-center justify-center transition-all disabled:cursor-not-allowed"
            type="button">
            <x-lucide-plus class="h-4 w-4 transition-transform group-active:scale-75" />
        </button>
    </div>
</div>
