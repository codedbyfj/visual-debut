@props(['product', 'mode' => 'grid', 'noCompare' => false])

{{-- blade-formatter-disable --}}
@php
  $productResource = (new \Webkul\Shop\Http\Resources\ProductResource($product))->resolve();
@endphp
{{-- blade-formatter-enable --}}

@if ($mode === 'grid')
    <div
        {{ $attributes->class('bg-surface group relative flex h-full flex-col overflow-hidden rounded-[--radius-xl] border border-on-background/5 shadow-sm transition-all duration-500 hover:shadow-2xl hover-lift') }}>
        <div class="relative aspect-[4/5] overflow-hidden bg-background/50">
            <img src="{{ $productResource['base_image']['medium_image_url'] }}" alt="{{ $productResource['name'] }}"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

            <!-- Badges -->
            <div class="absolute left-3 top-3 z-20 flex flex-col gap-1.5">
                @if ($productResource['on_sale'])
                    <span
                        class="rounded-full bg-danger px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-danger/20">
                        @lang('shop::app.components.products.card.sale')
                    </span>
                @endif
                @if ($productResource['is_new'])
                    <span
                        class="rounded-full bg-primary px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-primary/20">
                        @lang('shop::app.components.products.card.new')
                    </span>
                @endif
            </div>

            <!-- Hover Actions -->
            <div
                class="absolute inset-x-4 bottom-4 z-20 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                <div
                    class="bg-surface/90 border border-on-background/5 backdrop-blur-xl flex items-center justify-center gap-2 rounded-2xl p-2 shadow-2xl">
                    <livewire:add-to-cart-button :key="str()->random(16)" :product-id="$productResource['id']" size="md" circle />

                    @auth('customer')
                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <livewire:add-to-wishlist-button :key="str()->random(16)" :product-id="$productResource['id']" :in-user-wishlist="$productResource['is_wishlist']"
                                size="md" circle />
                        @endif
                    @endauth

                    @if (!$noCompare && core()->getConfigData('catalog.products.settings.compare_option'))
                        <livewire:add-to-compare-button :key="str()->random(16)" :product-id="$productResource['id']" size="md" circle />
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-1 flex-col p-5">
            <div class="mb-2">
                @if (isset($productResource['reviews']) && $productResource['reviews']['total'] > 0)
                    <div class="flex items-center gap-1.5">
                        <x-shop::star-rating :rating="$productResource['ratings']['average']" class="h-3 w-3" />
                        <span
                            class="text-on-surface/40 text-[10px] font-bold">({{ $productResource['reviews']['total'] }})</span>
                    </div>
                @endif
            </div>

            <a class="text-on-background group-hover:text-primary mb-2 line-clamp-2 text-base font-bold tracking-tight transition-colors before:absolute before:inset-0 before:z-10"
                href="{{ url($productResource['url_key']) }}">
                {{ $productResource['name'] }}
            </a>

            <div class="mt-auto flex items-center justify-between">
                <div class="text-on-surface flex items-baseline gap-2 text-lg font-black tracking-tighter">
                    {!! $productResource['price_html'] !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div
        {{ $attributes->class('bg-surface group relative flex w-full overflow-hidden rounded-[--radius-2xl] border border-on-background/5 shadow-sm transition-all duration-300 hover:shadow-xl sm:flex') }}>
        <div class="relative w-64 flex-shrink-0 overflow-hidden bg-background/50">
            <img src="{{ $productResource['base_image']['medium_image_url'] }}" alt="{{ $productResource['name'] }}"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">

            @if ($productResource['on_sale'] || $productResource['is_new'])
                <div class="absolute left-4 top-4 z-20 flex flex-col gap-1.5">
                    @if ($productResource['on_sale'])
                        <span
                            class="rounded-full bg-danger px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white shadow-lg">SALE</span>
                    @endif
                    @if ($productResource['is_new'])
                        <span
                            class="rounded-full bg-primary px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white shadow-lg">NEW</span>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex flex-1 flex-col justify-between p-8">
            <div class="flex-1">
                <div class="mb-4 flex items-start justify-between">
                    <div class="min-w-0 flex-1">
                        <a class="text-on-background group-hover:text-primary block text-2xl font-bold tracking-tight transition-colors"
                            href="{{ url($productResource['url_key']) }}">
                            {{ $productResource['name'] }}
                        </a>

                        <div
                            class="mt-2 text-on-surface flex items-baseline gap-3 text-2xl font-black tracking-tighter">
                            {!! $productResource['price_html'] !!}
                        </div>
                    </div>
                </div>

                @if (isset($productResource['reviews']) && $productResource['reviews']['total'] > 0)
                    <div class="mb-4 flex items-center gap-2">
                        <x-shop::star-rating :rating="$productResource['ratings']['average']" />
                        <span
                            class="text-on-surface/40 text-sm font-medium">({{ $productResource['reviews']['total'] }})</span>
                    </div>
                @endif

                <div class="text-on-surface/60 mb-8 line-clamp-3 text-sm leading-relaxed">
                    {!! visual_clear_inline_styles($product->short_description) !!}
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-on-background/5 pt-6">
                <div class="flex items-center gap-3">
                    @auth('customer')
                        @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                            <livewire:add-to-wishlist-button :key="str()->random(16)" :product-id="$productResource['id']" :in-user-wishlist="$productResource['is_wishlist']"
                                circle />
                        @endif
                    @endauth

                    @if (!$noCompare && core()->getConfigData('catalog.products.settings.compare_option'))
                        <livewire:add-to-compare-button key="add-to-compare-{{ $productResource['id'] }}-list"
                            :product-id="$productResource['id']" circle />
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <livewire:add-to-cart-button :key="str()->random(16)" x-data="{ submit() { this.$wire.addToCart() } }" :productId="$productResource['id']" />
                </div>
            </div>
        </div>
    </div>
@endif
