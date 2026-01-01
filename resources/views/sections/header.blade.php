@php
    $categories = $getCategories();
    $contentWidth = $section->settings->content_width ?? 'container';
    $containerClass = $contentWidth === 'container' ? 'mx-auto container' : 'px-4 sm:px-6 lg:px-8';
@endphp

<header {{ $section->editor_attributes }}
    class="bg-background/80 sticky top-0 z-50 w-full border-b border-on-background/5 shadow-sm backdrop-blur-2xl transition-all duration-300">
    <div class="{{ $containerClass }}">
        <div class="flex min-h-[5rem] items-center justify-between gap-x-8 py-2">
            <div class="flex items-center lg:hidden">
                <x-shop::ui.drawer placement="start" title="Menu">
                    <x-slot:trigger>
                        <button class="hover:bg-on-background/10 -ml-2 rounded-full p-2.5 transition-all"
                            aria-label="Open menu">
                            <x-lucide-menu class="h-6 w-6" />
                        </button>
                    </x-slot:trigger>
                    <div class="p-6">
                        <!-- Mobile Menu -->
                        <x-shop::mobile-menu :categories="$categories" />
                    </div>
                </x-shop::ui.drawer>
            </div>

            <div class="flex flex-1 items-center justify-between gap-8">
                @children
            </div>
        </div>
    </div>
</header>
