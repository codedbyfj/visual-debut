@php
    $itemClass =
        'group relative inline-flex h-12 items-center px-6 text-sm font-black uppercase tracking-widest transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }"
    class="relative hidden h-full items-center lg:flex" x-on:mouseleave="openItem = null">
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

    <!-- Mega Menu - Teleported to Body to prevent squashing -->
    <template x-teleport="body">
        <div x-show="openItem" x-on:mouseenter="openItem = openItem" x-on:mouseleave="openItem = null"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed inset-x-0 top-[80px] z-[9999] flex justify-center px-10 pt-2" x-cloak>

            <div
                class="w-full max-w-7xl overflow-hidden rounded-[--radius-4xl] border border-on-background/10 bg-white shadow-[0_32px_64px_-16px_rgba(0,0,0,0.2)] ring-1 ring-black/5">
                @foreach ($categories as $category)
                    @if ($category->children->isNotEmpty())
                        <div x-show="openItem === '{{ $category->id }}'"
                            class="flex w-full items-stretch min-h-[500px]">
                            <!-- Left spotlight Panel -->
                            <div
                                class="relative flex w-[420px] flex-shrink-0 flex-col justify-end bg-neutral-50 p-16 border-r border-neutral-100">
                                @if ($category->logo_url || $category->banner_url)
                                    <div class="absolute inset-0 grayscale opacity-10">
                                        <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                            class="h-full w-full object-cover">
                                    </div>
                                @endif
                                <div class="relative">
                                    <span
                                        class="mb-3 block text-[10px] font-black uppercase tracking-[0.4em] text-primary">Signature
                                        Boutique</span>
                                    <h3
                                        class="text-7xl font-black italic tracking-tighter text-on-background leading-none">
                                        {{ $category->name }}</h3>
                                    <a href="{{ $category->url }}"
                                        class="group/all mt-10 inline-flex items-center text-xs font-black uppercase tracking-widest text-primary hover:opacity-80">
                                        Explore Entire Collection
                                        <x-lucide-arrow-right
                                            class="ml-3 h-4 w-4 transition-transform group-hover/all:translate-x-2" />
                                    </a>
                                </div>
                            </div>
                            <!-- Categories Panel -->
                            <div class="flex-1 p-20 bg-white">
                                <div class="grid grid-cols-3 gap-x-16 gap-y-12">
                                    @foreach ($category->children as $subCategory)
                                        <div class="group/sub">
                                            <a href="{{ $subCategory->url }}" class="block">
                                                <span
                                                    class="block text-2xl font-black tracking-tight text-on-background group-hover/sub:text-primary leading-tight transition-colors">{{ $subCategory->name }}</span>
                                                @if ($subCategory->description)
                                                    <span
                                                        class="mt-3 block text-sm font-bold text-on-background/25 leading-relaxed line-clamp-2">{{ strip_tags($subCategory->description) }}</span>
                                                @endif
                                                <div
                                                    class="mt-6 h-1 w-0 bg-primary transition-all duration-300 group-hover/sub:w-10">
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </template>
</div>
