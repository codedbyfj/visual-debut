@php
    $itemClass =
        'group relative inline-flex h-14 items-center px-6 text-sm font-black uppercase tracking-widest text-on-background/90 transition-all duration-300 hover:text-primary focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }" x-navigation
    class="relative hidden h-full items-center lg:flex">

    <ul class="flex items-center">
        @foreach ($categories as $category)
            <li>
                <div class="relative">
                    @if ($category->children->isEmpty())
                        <a href="{{ $category->url }}" class="{{ $itemClass }}">
                            <span class="relative z-10">{{ $category->name }}</span>
                            <div
                                class="absolute inset-y-2 inset-x-1 rounded-full bg-primary/5 opacity-0 transition-all duration-300 group-hover:opacity-100">
                            </div>
                        </a>
                    @else
                        <button type="button" class="{{ $itemClass }}"
                            x-on:mouseenter="openItem = '{{ $category->id }}'" x-on:mouseleave="openItem = null"
                            x-navigation:item="{{ $category->id }}"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'text-primary' : ''">
                            <span class="relative z-10">{{ $category->name }}</span>
                            <div class="absolute inset-y-2 inset-x-1 rounded-full bg-primary/5 transition-all duration-300"
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
    <div x-navigation:dropdown x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" class="absolute left-1/2 top-full z-50 -translate-x-1/2 pt-6"
        x-cloak>

        <div
            class="w-[max(90vw,1200px)] max-w-7xl overflow-hidden rounded-[--radius-3xl] border border-on-background/5 bg-background shadow-[0_32px_64px_-16px_rgba(0,0,0,0.12)] ring-1 ring-black/5">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    <div x-navigation:section="{{ $category->id }}" class="grid grid-cols-12 items-stretch">
                        <!-- Left Panel: Brand / Visual -->
                        @php $hasImage = $category->logo_url || $category->banner_url; @endphp
                        <div
                            class="col-span-4 relative flex flex-col justify-end p-12 bg-on-background/[0.02] border-r border-on-background/5">
                            @if ($hasImage)
                                <div class="absolute inset-0 overflow-hidden">
                                    <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                        class="h-full w-full object-cover brightness-[0.8]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-background via-background/40 to-transparent">
                                    </div>
                                </div>
                            @endif
                            <div class="relative">
                                <span
                                    class="mb-3 block text-[11px] font-black uppercase tracking-[0.4em] text-primary">Signature
                                    Boutique</span>
                                <h3 class="text-5xl font-black italic tracking-tighter text-on-background">
                                    {{ $category->name }}</h3>
                                <p class="mt-6 text-sm font-medium text-on-background/50 leading-relaxed max-w-[280px]">
                                    Experience the pinnacle of style with our curated {{ strtolower($category->name) }}
                                    collection, where modern trends meet timeless elegance.
                                </p>
                                <a href="{{ $category->url }}"
                                    class="group/all mt-10 inline-flex items-center text-sm font-black uppercase tracking-widest text-primary">
                                    Browse All
                                    <x-lucide-arrow-right
                                        class="ml-3 h-4 w-4 transition-transform group-hover/all:translate-x-2" />
                                </a>
                            </div>
                        </div>

                        <!-- Right Panel: Links -->
                        <div class="col-span-8 p-16">
                            <div class="grid grid-cols-3 gap-x-16 gap-y-12">
                                @foreach ($category->children as $subCategory)
                                    <div class="group/link">
                                        <a href="{{ $subCategory->url }}" class="block">
                                            <span
                                                class="block text-lg font-black tracking-tight text-on-background transition-colors group-hover/link:text-primary">
                                                {{ $subCategory->name }}
                                            </span>
                                            @if ($subCategory->description)
                                                <span
                                                    class="mt-3 block text-xs font-bold text-on-background/40 leading-relaxed line-clamp-2">
                                                    {{ strip_tags($subCategory->description) }}
                                                </span>
                                            @endif
                                            <div
                                                class="mt-4 h-0.5 w-0 bg-primary transition-all duration-300 group-hover/link:w-8">
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
</div>
