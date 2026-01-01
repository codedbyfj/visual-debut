@php
    $itemClass =
        'group relative inline-flex h-12 items-center px-6 text-sm font-black uppercase tracking-widest transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }"
    class="relative hidden h-full items-center lg:flex" x-on:mouseleave="openItem = null">
    <!-- Top-Level Menu Items -->
    <ul class="flex items-center">
        @foreach ($categories as $category)
            <li>
                <div class="relative">
                    @if ($category->children->isEmpty())
                        <a href="{{ $category->url }}"
                            class="{{ $itemClass }} text-on-background/80 hover:text-primary">
                            <span class="relative z-10">{{ $category->name }}</span>
                            <div
                                class="absolute inset-y-2 inset-x-1 rounded-full bg-primary/10 opacity-0 transition-all duration-300 group-hover:opacity-100">
                            </div>
                        </a>
                    @else
                        <button type="button" class="{{ $itemClass }}"
                            x-on:mouseenter="openItem = '{{ $category->id }}'"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'text-primary' : 'text-on-background/80'">
                            <span class="relative z-10">{{ $category->name }}</span>
                            <div class="absolute inset-y-2 inset-x-1 rounded-full bg-primary/10 transition-all duration-300"
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

    <!-- Mega Menu Panel -->
    <div x-show="openItem" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed left-0 right-0 top-[var(--header-height,80px)] z-50 flex justify-center pt-2 px-10" x-cloak>

        <div
            class="w-full max-w-7xl overflow-hidden rounded-[--radius-3xl] border border-on-background/10 bg-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.15)] ring-1 ring-black/5">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    <div x-show="openItem === '{{ $category->id }}'" class="grid grid-cols-12 items-stretch">
                        <!-- Left Spotlight Panel -->
                        <div
                            class="col-span-4 relative flex flex-col justify-end p-16 bg-neutral-50 border-r border-neutral-100 min-h-[450px]">
                            @if ($category->logo_url || $category->banner_url)
                                <div class="absolute inset-0">
                                    <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                        class="h-full w-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-white via-white/20 to-transparent">
                                    </div>
                                </div>
                            @endif
                            <div class="relative">
                                <span
                                    class="mb-4 block text-[10px] font-black uppercase tracking-[0.4em] text-primary">Discover
                                    {{ $category->name }}</span>
                                <h3 class="text-6xl font-black italic tracking-tighter text-on-background leading-none">
                                    {{ $category->name }}</h3>
                                <a href="{{ $category->url }}"
                                    class="group/all mt-10 inline-flex items-center text-xs font-black uppercase tracking-[0.2em] text-on-background/40 hover:text-primary transition-colors">
                                    Shop Collection
                                    <x-lucide-arrow-right
                                        class="ml-3 h-4 w-4 transition-transform group-hover/all:translate-x-2" />
                                </a>
                            </div>
                        </div>

                        <!-- Right Categories Panel -->
                        <div class="col-span-8 p-16 bg-white">
                            <div class="grid grid-cols-3 gap-12">
                                @foreach ($category->children as $subCategory)
                                    <div class="group/link">
                                        <a href="{{ $subCategory->url }}" class="block">
                                            <span
                                                class="block text-xl font-black tracking-tight text-on-background transition-colors group-hover/link:text-primary">
                                                {{ $subCategory->name }}
                                            </span>
                                            @if ($subCategory->description)
                                                <span
                                                    class="mt-4 block text-xs font-medium text-neutral-400 leading-relaxed line-clamp-2">
                                                    {{ strip_tags($subCategory->description) }}
                                                </span>
                                            @endif
                                            <div
                                                class="mt-6 h-0.5 w-6 bg-neutral-100 transition-all duration-300 group-hover/link:w-12 group-hover/link:bg-primary">
                                            </div>
                                        </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
