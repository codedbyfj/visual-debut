@unless ($breadcrumbs->isEmpty())
    <div {{ $section->editor_attributes }} class="bg-primary/5 py-4">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-on-background/40"
                aria-label="breadcrumbs">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if ($breadcrumb->url && !$loop->last)
                        <a class="hover:text-primary transition-colors hover:underline" href="{{ $breadcrumb->url }}">
                            {{ $breadcrumb->title }}
                        </a>
                        <x-lucide-chevron-right class="h-3 w-3 opacity-50" />
                    @else
                        <span class="text-on-background/80 truncate">
                            {{ $breadcrumb->title }}
                        </span>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
@endunless
