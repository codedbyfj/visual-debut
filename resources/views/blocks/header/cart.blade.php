<div id="cart-preview" x-data x-dropdown="{ open: $wire.entangle('open') }" wire:init="initCart" class="relative"
    @visual_design_mode x-on:visual:block:select:{{ $block->id }}.window="$dropdown.open = true"
    x-on:visual:block:deselect:{{ $block->id }}.window="$dropdown.open = false" @end_visual_design_mode
    {{ $block->editor_attributes }}>
    <!-- Cart Button -->
    <button x-dropdown:trigger
        class="group hover:bg-background/80 relative flex h-11 w-11 items-center justify-center rounded-full transition-all duration-300"
        aria-label="cart preview">
        <x-lucide-shopping-bag class="h-5 w-5 transition-transform group-hover:scale-110" />
        @if (!$this->isCartEmpty() && $initialized)
            <span
                class="bg-primary text-on-primary absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full text-[10px] font-bold shadow-sm">
                {{ $this->getItemsCount() }}
            </span>
        @endif
    </button>

    <!-- Cart Preview -->
    <div x-cloak x-dropdown:content
        class="bg-surface/95 absolute end-0 mt-4 w-[380px] origin-top-right overflow-hidden rounded-[--radius-xl] border border-on-background/10 p-2 shadow-2xl backdrop-blur-xl">
        <!-- Header -->
        <div class="px-5 pb-4 pt-5">
            <h3 class="text-gradient mb-1 text-2xl font-bold tracking-tight" {!! $block->liveUpdate()->text('heading')->toHtml() !!}>
                {{ $block->settings->heading }}
            </h3>
            <div class="text-on-surface/60 prose prose-sm line-clamp-2 text-sm" {!! $block->liveUpdate()->html('description')->toHtml() !!}>
                {!! $block->settings->description !!}
            </div>
        </div>

        @if (!$this->isCartEmpty())
            <!-- Cart Items -->
            <div class="max-h-[400px] space-y-2 overflow-y-auto px-1 scrollbar-thin">
                @foreach ($this->getCartItems() as $item)
                    <div
                        class="hover:bg-background/50 group/item relative rounded-[--radius-lg] border border-transparent p-3 transition-all duration-200">
                        <div class="flex items-start gap-4">
                            <!-- Item Image -->
                            <div
                                class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-[--radius-md] border border-on-background/5">
                                <a class="block h-full w-full" href="{{ url($item->product_url_key) }}">
                                    <img src="{{ $item->base_image->small_image_url }}" alt="{{ $item->name }}"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover/item:scale-110" />
                                </a>
                            </div>

                            <!-- Item Details -->
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between">
                                    <h4
                                        class="text-on-surface block truncate text-sm font-bold leading-tight transition-colors group-hover/item:text-primary">
                                        <a href="{{ url($item->product_url_key) }}">
                                            {{ $item->name }}
                                        </a>
                                    </h4>
                                    <button
                                        class="hover:bg-danger/10 text-on-surface/40 hover:text-danger rounded-full p-1.5 transition-all"
                                        x-on:click="$confirm(() => $wire.removeItem({{ $item->id }}))">
                                        <x-lucide-x class="h-4 w-4" />
                                    </button>
                                </div>

                                <div class="mt-3 flex items-end justify-between">
                                    <!-- Quantity Controls -->
                                    <div
                                        class="flex items-center gap-2 rounded-full border border-on-background/10 bg-background/30 p-1">
                                        <button
                                            class="hover:bg-background text-on-surface/60 hover:text-primary rounded-full p-1 transition-all"
                                            wire:click="updateItemQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">
                                            <x-lucide-minus class="h-3 w-3" />
                                        </button>

                                        <span class="min-w-[24px] text-center text-[10px] font-bold">
                                            {{ $item->quantity }}
                                        </span>

                                        <button
                                            class="hover:bg-background text-on-surface/60 hover:text-primary rounded-full p-1 transition-all"
                                            wire:click="updateItemQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
                                            <x-lucide-plus class="h-3 w-3" />
                                        </button>
                                    </div>

                                    <!-- Item Price -->
                                    <div class="text-right">
                                        @if ($this->shouldDisplayCartPricesIncludingTax())
                                            <div class="text-on-surface text-sm font-bold">
                                                <x-shop::formatted-price :price="$item->price_incl_tax" />
                                            </div>
                                        @else
                                            <div class="text-on-surface text-sm font-bold">
                                                <x-shop::formatted-price :price="$item->price" />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Subtotal and Actions -->
            <div class="mt-4 space-y-3 rounded-[--radius-lg] bg-background/40 p-5">
                <!-- Subtotal -->
                <div class="flex items-center justify-between border-b border-on-background/5 pb-3">
                    <span class="text-on-surface/60 text-sm font-medium">
                        @lang('shop::app.checkout.cart.mini-cart.subtotal')
                    </span>
                    <span class="text-on-surface text-lg font-bold tracking-tight">
                        {{ $this->shouldDisplayCartSubtotalIncludingTax() ? $this->getFormattedCartSubtotalWithTax() : $this->getFormattedCartSubtotal() }}
                    </span>
                </div>

                <div class="grid gap-2 pt-1">
                    <x-shop::ui.button block href="{{ route('shop.checkout.onepage.index') }}" color="primary"
                        class="h-12 shadow-lg shadow-primary/20">
                        @lang('shop::app.checkout.cart.mini-cart.continue-to-checkout')
                    </x-shop::ui.button>

                    <a href="{{ route('shop.checkout.cart.index') }}"
                        class="text-on-surface/60 hover:text-on-surface block py-2 text-center text-xs font-bold uppercase tracking-widest transition-colors">
                        @lang('shop::app.checkout.cart.mini-cart.view-cart')
                    </a>
                </div>
            </div>
        @else
            <!-- Empty Cart Message -->
            <div class="flex flex-col items-center px-10 py-16 text-center">
                <div class="bg-primary/5 text-primary mb-6 flex h-24 w-24 items-center justify-center rounded-full">
                    <x-lucide-shopping-bag class="h-10 w-10 opacity-40" />
                </div>
                <p class="text-on-surface/60 mb-8 text-sm leading-relaxed">
                    @lang('shop::app.checkout.cart.mini-cart.empty-cart')
                </p>

                <x-shop::ui.button href="/" class="px-8 shadow-sm">
                    @lang('visual-debut::shop.cart.start-shopping')
                </x-shop::ui.button>
            </div>
        @endif
    </div>
</div>
