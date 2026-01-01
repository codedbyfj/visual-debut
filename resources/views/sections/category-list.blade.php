@php
    use BagistoPlus\VisualDebut\Tailwind;

    // Content width
    $widthClass = $section->settings->content_width === 'container' ? 'mx-auto container' : 'px-4 sm:px-6 lg:px-8';

    $columnClasses = Tailwind::responsive($section->settings->columns, fn($v) => "grid-cols-{$v}");
    $gapClass = 'gap-' . ($section->settings->gap ?? 8);
@endphp

<div {{ $section->editor_attributes }} {{ $section->settings->color_scheme?->attributes() }}
    class="section-padding bg-background">
    <div class="{{ $widthClass }}">
        <div class="mb-12 flex items-end justify-between">
            @children
        </div>

        <div class="{{ $columnClasses }} {{ $gapClass }} grid">
            @foreach ($categoryItems as $category)
                <a href="{{ $category->url }}"
                    class="group relative aspect-square overflow-hidden rounded-[--radius-2xl] shadow-lg transition-all duration-500 hover:shadow-2xl hover-lift">
                    @if ($category->logo_url || $category->banner_url)
                        <img src="{{ $category->logo_url ?? $category->banner_url }}"
                            class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-accent/10"></div>
                        <div class="absolute inset-0 flex items-center justify-center p-8 opacity-10">
                            <x-lucide-image class="h-12 w-12" />
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0 p-8">
                        <h3
                            class="text-2xl font-black tracking-tight text-white transition-transform duration-300 group-hover:-translate-y-1">
                            {{ $category->name }}
                        </h3>
                        <div class="mt-2 h-1 w-0 bg-primary transition-all duration-300 group-hover:w-12"></div>
                    </div>
                </a>
            @endforeach

            @if ($categoryItems->isEmpty())
                @visual_design_mode
                @for ($i = 1; $i <= 4; $i++)
                    <div
                        class="group relative aspect-square overflow-hidden rounded-[--radius-2xl] bg-surface-alt shadow-lg hover-lift">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-accent/5"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <h3 class="text-xl font-black tracking-tight text-on-surface/20">Category
                                {{ $i }}</h3>
                        </div>
                    </div>
                @endfor
                @end_visual_design_mode
            @endif
        </div>
    </div>
</div>
