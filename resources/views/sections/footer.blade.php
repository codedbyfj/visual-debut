@php
    $contentWidthClass =
        $section->settings->content_width === 'container' ? 'mx-auto container' : 'px-4 sm:px-6 lg:px-8';
@endphp

<footer {{ $section->editor_attributes }}
    class="bg-on-background/10 text-on-background/60 border-t border-on-background/5">
    <div class="{{ $contentWidthClass }} section-padding">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-8">
            @children
        </div>

        <div class="mt-20 border-t border-on-background/5 pt-8">
            <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
                <p class="text-sm font-medium opacity-40">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>

                <div
                    class="flex items-center gap-8 opacity-40 grayscale transition-all hover:opacity-100 hover:grayscale-0">
                    <x-lucide-credit-card class="h-6 w-6" />
                    <x-lucide-shield-check class="h-6 w-6" />
                </div>
            </div>
        </div>
    </div>
</footer>
