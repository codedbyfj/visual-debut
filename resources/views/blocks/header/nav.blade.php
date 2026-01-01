@php
    $itemClass =
        'group inline-flex h-11 w-max items-center justify-center rounded-full px-5 py-2 text-sm font-bold tracking-tight transition-all duration-300 hover:bg-on-background/5 hover:text-primary aria-expanded:bg-primary/10 aria-expanded:text-primary focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data x-navigation
    class="relative hidden h-full items-center lg:flex">
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
                            class="{{ $itemClass }} aria-expanded:bg-on-background/5 aria-expanded:text-primary"
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

    <div x-navigation:dropdown x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" class="absolute top-full left-0 z-50 pt-4" x-cloak>
        <div
            class="min-w-[40rem] overflow-hidden rounded-[--radius-2xl] border border-on-background/10 bg-white p-2 shadow-2xl ring-1 ring-black/5">
            @foreach ($categories as $category)
                @if ($category->children->isNotEmpty())
                    @php $hasImage = $category->logo_url || $category->banner_url; @endphp
                    <div x-navigation:section="{{ $category->id }}"
                        class="{{ $hasImage ? 'max-w-4xl' : 'max-w-2xl' }} flex w-full items-stretch justify-center gap-x-8 p-8">
                        @if ($hasImage)
                            <div
                                class="group/nav-img relative flex h-full min-h-[300px] w-56 flex-shrink-0 items-end overflow-hidden rounded-[--radius-lg] p-6 shadow-lg shadow-black/10">
                                <img src="{{ $category->logo_url ?? $category->banner_url }}"
                                    class="absolute inset-0 h-full w-full object-cover brightness-[0.4] transition-transform duration-700 group-hover/nav-img:scale-110">
                                <div class="relative space-y-2">
                                    <span class="block text-xl font-bold text-white">{{ $category->name }}</span>
                                    <x-shop::ui.button href="{{ $category->url }}" variant="primary" size="xs"
                                        class="mt-2">
                                        Shop All
                                    </x-shop::ui.button>
                                </div>
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="grid grid-cols-2 gap-8">
                                @foreach ($category->children as $subCategory)
                                    <div class="space-y-4">
                                        <a x-navigation:sub-item href="{{ $subCategory->url }}"
                                            class="hover-lift group/sub block">
                                            <span
                                                class="mb-1 block text-sm font-bold tracking-tight text-on-background group-hover/sub:text-primary transition-colors">
                                                {{ $subCategory->name }}
                                            </span>
                                            @if ($subCategory->description)
                                                <span
                                                    class="text-on-background/40 block text-xs leading-relaxed line-clamp-2">
                                                    {!! $subCategory->description !!}
                                                </span>
                                            @endif
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
