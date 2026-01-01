@php
    $itemClass =
        'group relative inline-flex h-20 items-center px-6 text-sm font-bold uppercase tracking-wide transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{ openItem: null }" x-on:mouseleave="openItem = null"
    class="flex h-20 items-center justify-center">
    <!-- Main Navigation Links -->
    <ul class="flex h-full items-center list-none m-0 p-0 space-x-2">
        @foreach ($categories as $category)
            <li class="h-full flex items-center">
                <a href="{{ $category->url }}" x-on:mouseenter="openItem = '{{ $category->id }}'"
                    class="{{ $itemClass }} {{ request()->url() == $category->url ? 'text-[#E32E2E]' : 'text-[#1A202C] hover:text-[#E32E2E]' }}">
                    <span class="relative z-10">{{ $category->name }}</span>

                    @if ($category->children->isNotEmpty())
                        <x-lucide-chevron-down
                            class="ml-1.5 h-4 w-4 opacity-50 transition-transform duration-300 group-hover:rotate-180"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'rotate-180 text-[#E32E2E]' : ''" />
                    @endif

                    <!-- Active Underline Header Link -->
                    <div class="absolute bottom-0 left-6 right-6 h-0.5 bg-[#E32E2E] transition-all duration-300 origin-center scale-x-0 group-hover:scale-x-100"
                        x-bind:class="openItem === '{{ $category->id }}' ? 'scale-x-100' : ''"></div>
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Mega Menu Dropdown -->
    <template x-teleport="body">
        <div x-show="openItem" x-on:mouseenter="openItem = openItem" x-on:mouseleave="openItem = null"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed inset-x-0 top-20 z-[80] flex justify-center px-4" x-cloak>
            <!-- Background Backdrop for smooth hover bridge -->
            <div class="absolute inset-x-0 -top-4 h-4 bg-transparent"></div>

            <div
                class="w-full max-w-7xl overflow-hidden rounded-b-2xl border-x border-b border-gray-100 bg-white shadow-2xl">
                @foreach ($categories as $category)
                    @if ($category->children->isNotEmpty())
                        <div x-show="openItem === '{{ $category->id }}'" class="p-10 flex">
                            <!-- Category Image/Featured (Optional but keeps it premium) -->
                            <div class="w-1/4 pr-10 border-r border-gray-100">
                                <div class="relative overflow-hidden rounded-xl aspect-[4/5] bg-gray-50">
                                    @if ($category->logo_url || $category->banner_url)
                                        <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                            class="absolute inset-0 w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                                        </div>
                                        <div
                                            class="absolute bottom-6 left-6 text-white text-xl font-bold uppercase tracking-wider">
                                            {{ $category->name }}</div>
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-gray-200 uppercase font-black text-4xl transform -rotate-12">
                                            {{ $category->name }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Mega Menu Sub-items Grid -->
                            <div class="flex-1 pl-10">
                                <h4 class="text-[11px] font-black uppercase tracking-[0.3em] text-[#E32E2E] mb-6">
                                    Explore {{ $category->name }}</h4>
                                <div class="grid grid-cols-3 gap-x-12 gap-y-10">
                                    @foreach ($category->children as $subCategory)
                                        <div class="group/sub">
                                            <a href="{{ $subCategory->url }}" class="block">
                                                <span
                                                    class="block text-lg font-bold text-[#1A202C] group-hover/sub:text-[#E32E2E] transition-colors mb-1">
                                                    {{ $subCategory->name }}
                                                </span>
                                                @if ($subCategory->description)
                                                    <span
                                                        class="block text-sm text-gray-400 font-medium leading-relaxed line-clamp-2">
                                                        {{ strip_tags($subCategory->description) }}
                                                    </span>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-12 pt-8 border-t border-gray-50">
                                    <a href="{{ $category->url }}"
                                        class="inline-flex items-center text-xs font-black uppercase tracking-widest text-[#E32E2E] hover:translate-x-1 transition-transform">
                                        View All {{ $category->name }} Categories
                                        <x-lucide-chevron-right class="ml-2 h-4 w-4" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </template>
</div>
