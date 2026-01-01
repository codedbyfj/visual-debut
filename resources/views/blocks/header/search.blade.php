<div {{ $block->editor_attributes }} id="search-form">
    <div x-data="{ showSearch: false }">
        <button
            class="group hover:bg-on-background/10 flex h-11 w-11 items-center justify-center rounded-full transition-all duration-300"
            aria-label="Search" x-on:click="showSearch = !showSearch">
            @svg($block->settings->search_icon ?? 'lucide-search', ['class' => 'h-5 w-5 transition-transform group-hover:scale-110'])
        </button>

        <template x-teleport="body">
            <div x-cloak x-show="showSearch" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[60] flex items-start justify-center p-4 pt-20 backdrop-blur-sm"
                @keydown.escape.window="showSearch = false">
                <div class="fixed inset-0 bg-background/60" x-on:click="showSearch = false"></div>

                <div class="relative w-full max-w-3xl overflow-hidden rounded-[--radius-2xl] border border-on-background/5 bg-surface p-6 shadow-2xl transition-all duration-300"
                    x-on:click.stop>
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-xl font-bold tracking-tight">Search Products</h2>
                        <button @click="showSearch = false"
                            class="hover:bg-background rounded-full p-2 transition-colors">
                            <x-lucide-x class="h-6 w-6" />
                        </button>
                    </div>

                    <form method="get" action="{{ route('shop.search.index') }}" class="relative">
                        @foreach (collect(request()->query())->except('query') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value=@json($value)>
                        @endforeach

                        <div class="relative flex items-center gap-3">
                            <div class="relative flex-1">
                                <x-lucide-search
                                    class="text-on-background/40 absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2" />
                                <input type="search" name="query" autofocus value="{{ request('query') }}"
                                    class="h-14 w-full rounded-2xl border-none bg-background/50 pl-12 pr-12 text-lg focus:ring-2 focus:ring-primary/20 transition-all"
                                    placeholder="What are you looking for?">
                            </div>

                            @if (core()->getConfigData('catalog.products.settings.image_search'))
                                <x-shop::image-search-button :icon="$block->settings->image_search_icon ?? 'lucide-camera'"
                                    class="hover:bg-background flex h-14 w-14 items-center justify-center rounded-2xl border border-on-background/5 transition-all" />
                            @endif
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            <span
                                class="text-on-background/40 w-full text-xs font-bold uppercase tracking-widest">Popular
                                Searches</span>
                            <button type="button"
                                class="bg-background/50 hover:bg-background rounded-full px-4 py-1.5 text-xs font-medium transition-all">Summer
                                Collection</button>
                            <button type="button"
                                class="bg-background/50 hover:bg-background rounded-full px-4 py-1.5 text-xs font-medium transition-all">New
                                Arrivals</button>
                            <button type="button"
                                class="bg-background/50 hover:bg-background rounded-full px-4 py-1.5 text-xs font-medium transition-all">Best
                                Sellers</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</div>
