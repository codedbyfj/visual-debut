@php
    $itemClass =
        'group inline-flex h-11 w-max items-center justify-center rounded-full px-5 py-2 text-sm font-bold tracking-tight transition-all duration-300 hover:bg-white hover:shadow-sm hover:text-primary aria-expanded:bg-white aria-expanded:shadow-md aria-expanded:text-primary focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data x-navigation
    class="relative hidden h-full items-center lg:flex rounded-full bg-on-background/5 p-1">
    <div class="h-full">
        <ul class="flex h-full list-none items-center justify-center space-x-1">
            @foreach ($categories as $category)
                <li class="h-full flex items-center">
                    @if ($category->children->isEmpty())
                        <a href="{{ $category->url }}" class="{{ $itemClass }}">
                            {{ $category->name }}
                        </a>
                    @else
                        <a href="{{ $category->url }}"
                            class="{{ $itemClass }} aria-expanded:bg-white aria-expanded:shadow-md aria-expanded:text-primary"
                            x-navigation:item="{{ $category->id }}">
                            {{ $category->name }}
                            <x-lucide-chevron-down
                                class="ml-1.5 h-3 w-3 opacity-40 transition-transform group-hover:rotate-180 group-aria-expanded:rotate-180" />
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div x-navigation:dropdown x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-10 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 scale-95"
        class="absolute left-1/2 top-full z-50 -translate-x-1/2 pt-6" x-cloak>
        <div
            class="min-w-[56rem] overflow-hidden rounded-[--radius-3xl] border border-on-background/10 bg-white shadow-2xl ring-1 ring-black/5">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    @php $hasImage = $category->logo_url || $category->banner_url; @endphp
                    <div x-navigation:section="{{ $category->id }}"
                        class="{{ $hasImage ? 'max-w-6xl' : 'max-w-4xl' }} flex w-full items-stretch justify-start gap-x-12 p-12">
                        @if ($hasImage)
                            <div
                                class="group/nav-img relative flex h-full min-h-[400px] w-80 flex-shrink-0 items-end overflow-hidden rounded-[--radius-2xl] p-8 shadow-2xl transition-all duration-500 hover:shadow-primary/20">
                                <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                    class="absolute inset-0 h-full w-full object-cover brightness-[0.4] transition-transform duration-1000 group-hover/nav-img:scale-110">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent">
                                </div>
                                <div class="absolute inset-0 bg-primary/10 mix-blend-overlay"></div>
                                <div class="relative space-y-4">
                                    <h3 class="text-3xl font-black leading-tight tracking-tighter text-white">
                                        {{ $category->name }}
                                    </h3>
                                    <x-shop::ui.button href="{{ $category->url }}" variant="primary" size="sm"
                                        class="rounded-full px-8 shadow-lg shadow-primary/20">
                                        Shop All
                                    </x-shop::ui.button>
                                </div>
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="mb-8 border-b border-on-background/5 pb-4">
                                <span
                                    class="text-on-surface/40 text-[11px] font-black uppercase tracking-[0.2em]">Explore
                                    Categories</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach ($category->children as $subCategory)
                                    <a x-navigation:sub-item href="{{ $subCategory->url }}"
                                        class="hover:bg-primary/5 group/sub block rounded-[--radius-2xl] p-6 transition-all duration-300">
                                        <span
                                            class="mb-2 block text-base font-bold tracking-tight text-on-surface group-hover/sub:text-primary transition-colors">
                                            {{ $subCategory->name }}
                                        </span>
                                        @if ($subCategory->description)
                                            <span
                                                class="text-on-surface/40 block text-xs font-medium leading-relaxed line-clamp-2">
                                                {!! visual_clear_inline_styles($subCategory->description) !!}
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
