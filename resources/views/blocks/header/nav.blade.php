@php
    $itemClass =
        'group relative inline-flex h-20 items-center px-6 text-sm font-black uppercase tracking-widest transition-all duration-300 focus:outline-none';
@endphp

<div id="navigation" {{ $block->editor_attributes }} x-data="{
    openItem: null,
    timer: null,
    enter(id) {
        clearTimeout(this.timer);
        this.openItem = id;
    },
    leave() {
        this.timer = setTimeout(() => {
            this.openItem = null;
        }, 100);
    }
}" class="flex h-full items-center">
    <!-- Top-Level Menu -->
    <ul class="flex h-full items-center">
        @foreach ($categories as $category)
            <li class="h-full">
                <div class="relative h-full flex items-center">
                    <a href="{{ $category->url }}" x-on:mouseenter="enter('{{ $category->id }}')" x-on:mouseleave="leave()"
                        class="{{ $itemClass }}"
                        x-bind:class="openItem === '{{ $category->id }}' ? 'text-primary' : 'text-on-background/80'">
                        <span class="relative z-10">{{ $category->name }}</span>
                        <!-- Active Pill -->
                        <div class="absolute inset-y-4 inset-x-2 rounded-full bg-primary/10 transition-all duration-300"
                            x-bind:class="openItem === '{{ $category->id }}' ? 'opacity-100' : 'opacity-0'"></div>

                        @if ($category->children->isNotEmpty())
                            <x-lucide-chevron-down class="ml-2 h-4 w-4 opacity-40 transition-transform"
                                x-bind:class="openItem === '{{ $category->id }}' ? 'rotate-180' : ''" />
                        @endif
                    </a>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- MEGA MENU - Teleported to Body to Break Out of Header Trap -->
    <template x-teleport="body">
        <div x-show="openItem" x-on:mouseenter="clearTimeout(timer)" x-on:mouseleave="leave()"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="fixed inset-x-0 top-20 z-[99999] flex justify-center px-6" x-cloak>
            <!-- Background Panel -->
            <div
                class="w-full max-w-6xl overflow-hidden rounded-b-[40px] border-x border-b border-black/5 bg-white shadow-[0_40px_80px_-20px_rgba(0,0,0,0.15)]">
                @foreach ($categories as $category)
                    @if ($category->children->isNotEmpty())
                        <div x-show="openItem === '{{ $category->id }}'" class="p-16">
                            <div class="grid grid-cols-4 gap-x-12 gap-y-12">
                                @foreach ($category->children as $subCategory)
                                    <div>
                                        <a href="{{ $subCategory->url }}" class="group/sub block">
                                            <span
                                                class="block text-xl font-black tracking-tight text-on-background group-hover/sub:text-primary transition-colors leading-tight">
                                                {{ $subCategory->name }}
                                            </span>
                                            @if ($subCategory->description)
                                                <span
                                                    class="mt-3 block text-sm font-bold text-on-background/30 leading-relaxed line-clamp-2">
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
    </template>
</div>
