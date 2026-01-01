@php
    $itemClass =
        'group relative inline-flex h-12 items-center px-6 text-sm font-black uppercase tracking-widest transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }"
    class="relative hidden h-full items-center lg:flex">
    <!-- Top-Level Menu Items -->
    <ul class="flex h-full items-center">
        @foreach ($categories as $category)
            <li class="h-full">
                <div class="relative h-full flex items-center">
                    @if ($category->children->isEmpty())
                        <a href="{{ $category->url }}"
                            class="{{ $itemClass }} text-on-background/80 hover:text-primary">
                            <span class="relative z-10">{{ $category->name }}</span>
                            <div
                                class="absolute inset-y-2 inset-x-0 rounded-full bg-primary/20 opacity-0 transition-all duration-300 group-hover:opacity-100">
                            </div>
                        </a>
                    @else
                        <button type="button" class="{{ $itemClass }}"
                            x-on:mouseenter="openItem = '{{ $category->id }}'"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'text-primary' : 'text-on-background/80'">
                            <span class="relative z-10">{{ $category->name }}</span>
                            <div class="absolute inset-y-2 inset-x-0 rounded-full bg-primary/20 transition-all duration-300"
                                x-bind:class="openItem === '{{ $category->id }}' ? 'opacity-100' : 'opacity-0'"></div>

                            <x-lucide-chevron-down
                                class="relative z-10 ml-2 h-4 w-4 opacity-40 transition-transform duration-300"
                                x-bind:class="openItem === '{{ $category->id }}' ? 'rotate-180 opacity-100' : ''" />
                        </button>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Simplified Mega Menu - Pure Name & Description -->
    <div x-show="openItem" x-on:mouseleave="openItem = null" class="fixed inset-x-0 top-[80px] z-[9999] px-10 pt-2"
        x-cloak>

        <!-- Hover Bridge -->
        <div class="absolute inset-x-0 -top-4 h-4 bg-transparent" x-on:mouseenter="openItem = openItem"></div>

        <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            class="mx-auto w-full max-w-5xl overflow-hidden rounded-[--radius-4xl] border border-on-background/10 bg-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.15)] ring-1 ring-black/5">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    <div x-show="openItem === '{{ $category->id }}'" class="p-16 bg-white">
                        <div class="grid grid-cols-3 gap-x-12 gap-y-10">
                            @foreach ($category->children as $subCategory)
                                <div class="group/sub">
                                    <a href="{{ $subCategory->url }}" class="block">
                                        <span
                                            class="block text-xl font-black tracking-tight text-on-background group-hover/sub:text-primary transition-colors leading-tight">
                                            {{ $subCategory->name }}
                                        </span>
                                        @if ($subCategory->description)
                                            <span
                                                class="mt-2 block text-sm font-bold text-on-background/20 leading-relaxed line-clamp-2">
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
