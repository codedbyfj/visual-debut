@php
    $itemClass =
        'group relative inline-flex h-20 items-center px-8 text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }" x-on:mouseleave="openItem = null"
    class="flex h-20 items-center">
    <!-- Main Menu Links -->
    <ul class="flex h-20 items-center list-none m-0 p-0">
        @foreach ($categories as $category)
            <li class="h-20 flex items-center">
                <a href="{{ $category->url }}" x-on:mouseenter="openItem = '{{ $category->id }}'"
                    class="{{ $itemClass }}"
                    x-bind:class="openItem === '{{ $category->id }}' ? 'text-primary' : 'text-on-background/70'">
                    <span class="relative z-10">{{ $category->name }}</span>
                    <!-- Hover Pill Background -->
                    <div class="absolute inset-y-5 inset-x-2 rounded-full bg-primary/10 transition-all duration-300"
                        x-bind:class="openItem === '{{ $category->id }}' ? 'opacity-100' : 'opacity-0'"></div>

                    @if ($category->children->isNotEmpty())
                        <x-lucide-chevron-down class="ml-2 h-3.5 w-3.5 opacity-40 transition-transform duration-300"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'rotate-180 opacity-100' : ''" />
                    @endif
                </a>
            </li>
        @endforeach
    </ul>

    <!-- FORCED FULL-WIDTH MEGA MENU -->
    <!-- Positioned fixed left-0 right-0 to break out of any container traps -->
    <div x-show="openItem" x-on:mouseenter="openItem = openItem" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed left-0 right-0 top-20 z-[60] flex justify-center px-10 pt-1 pointer-events-none" x-cloak>
        <!-- The Actual Menu Panel (with pointer events restored) -->
        <div
            class="w-full max-w-7xl overflow-hidden rounded-3xl border border-on-background/5 bg-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.18)] pointer-events-auto">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    <div x-show="openItem === '{{ $category->id }}'" class="p-16 bg-white">
                        <div class="grid grid-cols-4 gap-x-12 gap-y-12">
                            @foreach ($category->children as $subCategory)
                                <div class="group/sub">
                                    <a href="{{ $subCategory->url }}" class="block">
                                        <span
                                            class="block text-xl font-bold tracking-tight text-on-background group-hover/sub:text-primary transition-colors leading-tight">
                                            {{ $subCategory->name }}
                                        </span>
                                        @if ($subCategory->description)
                                            <span
                                                class="mt-2 block text-sm font-medium text-on-background/30 leading-relaxed line-clamp-2">
                                                {{ strip_tags($subCategory->description) }}
                                            </span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
