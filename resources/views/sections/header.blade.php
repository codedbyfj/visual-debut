@php
    $categories = $getCategories();
    $contentWidth = $section->settings->content_width ?? 'container';
    $containerClass = $contentWidth === 'container' ? 'mx-auto container' : 'px-4 sm:px-6 lg:px-8';
@endphp

<div {{ $section->editor_attributes }}
    class="glass-panel sticky top-0 z-50 w-full border-b border-on-background/5 transition-all duration-300">
    <div class="{{ $containerClass }}">
        <div class="flex h-20 items-center justify-between gap-x-8">
            <x-shop::ui.drawer placement="start" title="Menu">
                <x-slot:trigger>
                    <button class="hover:bg-background/50 -ml-2 rounded-full p-2.5 transition-all sm:hidden"
                        aria-label="Open menu">
                        <x-lucide-menu class="h-6 w-6" />
                    </button>
                </x-slot:trigger>
                <div class="p-6">
                    <!-- Mobile Menu -->
                    <x-shop::mobile-menu :categories="$categories" />
                </div>
            </x-shop::ui.drawer>

            @children
        </div>
    </div>
</div>
