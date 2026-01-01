@php
    $itemClass =
        'group relative inline-flex h-20 items-center px-6 text-sm font-black uppercase tracking-widest transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }" class="flex h-full items-center">
    <!-- Top-Level Menu -->
    <ul class="flex h-full items-center">
        @foreach ($categories as $category)
            <li class="h-full" x-on:mouseenter="openItem = '{{ $category->id }}'" x-on:mouseleave="openItem = null">

                <div class="relative h-full flex items-center">
                    <a href="{{ $category->url }}" class="{{ $itemClass }}"
                        x-bind:class="openItem === '{{ $category->id }}' ? 'text-primary' : 'text-on-background/80'">
                        <span class="relative z-10">{{ $category->name }}</span>
                        <!-- Hover Pill -->
                        <div class="absolute inset-y-4 inset-x-2 rounded-full bg-primary/10 transition-all duration-300"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'opacity-100' : 'opacity-0'"></div>

                        @if ($category->children->isNotEmpty())
                            <x-lucide-chevron-down class="ml-2 h-4 w-4 opacity-40" />
                        @endif
                    </a>

                    <!-- MEGA MENU PANEL - Fixed width breakout -->
                    @if ($category->children->isNotEmpty())
                        <div x-show="openItem === '{{ $category->id }}'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="!fixed inset-x-0 top-20 z-[9999] flex justify-center px-6 pt-2" x-cloak>

                            <!-- Invisible Bridge -->
                            <div class="absolute inset-x-0 -top-4 h-4 bg-transparent"></div>

                            <!-- Mega Menu Container -->
                            <div
                                class="w-full max-w-6xl overflow-hidden rounded-[--radius-4xl] border border-black/5 bg-white shadow-[0_40px_80px_-16px_rgba(0,0,0,0.25)]">
                                <div class="p-16 grid grid-cols-4 gap-x-12 gap-y-12">
                                    @foreach ($category->children as $subCategory)
                                        <div class="group/sub">
                                            <a href="{{ $subCategory->url }}" class="block">
                                                <span
                                                    class="block text-xl font-black tracking-tight text-on-background group-hover/sub:text-primary transition-colors leading-tight">
                                                    {{ $subCategory->name }}
                                                </span>
                                                @if ($subCategory->description)
                                                    <span
                                                        class="mt-3 block text-sm font-bold text-on-background/25 leading-relaxed line-clamp-2">
                                                        {{ strip_tags($subCategory->description) }}
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
