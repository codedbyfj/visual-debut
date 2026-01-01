@php
    $itemClass =
        'group inline-flex h-10 items-center justify-center rounded-full px-5 text-sm font-bold tracking-tight transition-all duration-300 hover:bg-white hover:text-primary hover:shadow-sm focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }" x-navigation
    class="relative hidden h-full items-center lg:flex">

    <!-- Navigation Pill Container -->
    <nav class="flex items-center space-x-1 rounded-full bg-neutral-100 p-1.5 shadow-inner">
        @foreach ($categories as $category)
            <div class="relative">
                @if ($category->children->isEmpty())
                    <a href="{{ $category->url }}" class="{{ $itemClass }}">
                        {{ $category->name }}
                    </a>
                @else
                    <button type="button" class="{{ $itemClass }}"
                        x-bind:class="openItem === '{{ $category->id }}' ? 'bg-white text-primary shadow-sm' : ''"
                        x-navigation:item="{{ $category->id }}" x-on:mouseenter="openItem = '{{ $category->id }}'"
                        x-on:mouseleave="openItem = null">
                        {{ $category->name }}
                        <x-lucide-chevron-down class="ml-1.5 h-3.5 w-3.5 opacity-40 transition-transform"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'rotate-180' : ''" />
                    </button>
                @endif
            </div>
        @endforeach
    </nav>

    <!-- Mega Menu Dropdown -->
    <div x-navigation:dropdown x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" class="absolute left-0 top-full z-50 pt-4"
        style="min-width: 800px;" x-cloak>

        <div
            class="overflow-hidden rounded-[--radius-3xl] border border-neutral-200 bg-white shadow-2xl ring-1 ring-black/5">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    <div x-navigation:section="{{ $category->id }}" class="flex w-full items-stretch gap-10 p-10">
                        <!-- Featured Image Block -->
                        @php $hasImage = $category->logo_url || $category->banner_url; @endphp
                        @if ($hasImage)
                            <div
                                class="relative min-h-[300px] w-72 flex-shrink-0 overflow-hidden rounded-[--radius-2xl] shadow-lg">
                                <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                    class="absolute inset-0 h-full w-full object-cover brightness-50">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                <div class="relative flex h-full items-end p-8">
                                    <h3 class="text-3xl font-black text-white tracking-tighter">{{ $category->name }}
                                    </h3>
                                </div>
                            </div>
                        @endif

                        <!-- Category List -->
                        <div class="flex-1">
                            <div class="mb-6 flex items-center space-x-2">
                                <div class="h-px w-8 bg-primary"></div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-neutral-400">Discover
                                    {{ $category->name }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-left">
                                @foreach ($category->children as $subCategory)
                                    <a href="{{ $subCategory->url }}"
                                        class="group/sub flex flex-col rounded-[--radius-xl] p-4 transition-all hover:bg-neutral-50">
                                        <span
                                            class="text-sm font-bold text-neutral-900 group-hover/sub:text-primary transition-colors">
                                            {{ $subCategory->name }}
                                        </span>
                                        @if ($subCategory->description)
                                            <span class="mt-1 text-xs text-neutral-400 line-clamp-2 font-medium">
                                                {!! strip_tags($subCategory->description) !!}
                                            </span>
                                        @endif
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
