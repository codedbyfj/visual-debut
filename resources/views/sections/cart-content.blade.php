<div {{ $section->editor_attributes }} class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-gradient mb-12 text-5xl font-black tracking-tighter">
            @lang('shop::app.checkout.cart.index.cart')
        </h1>

        @if ($this->isCartEmpty())
            <div
                class="flex flex-col items-center justify-center rounded-[--radius-2xl] bg-surface/50 py-24 text-center backdrop-blur-sm">
                <div class="bg-primary/10 text-primary mb-6 flex h-24 w-24 items-center justify-center rounded-full">
                    <x-lucide-shopping-bag class="h-10 w-10 opacity-40" />
                </div>
                <p class="text-on-surface/60 mb-8 max-w-sm text-lg leading-relaxed">
                    @lang('shop::app.checkout.cart.index.empty-product')
                </p>

                <x-shop::ui.button href="{{ route('shop.home.index') }}" color="primary"
                    class="h-14 px-10 shadow-lg shadow-primary/20">
                    {{ __('shop::app.checkout.cart.index.continue-shopping') }}
                </x-shop::ui.button>
            </div>
        @else
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3" x-data="{
                allSelected: false,
                selected: $wire.entangle('itemsSelected'),
                items: @json(collect($cart->items)->pluck('id')),
                toggleAll() {
                    if (!this.allSelected) {
                        this.selected = this.items;
                        this.allSelected = true;
                    } else {
                        this.selected = [];
                        this.allSelected = false;
                    }
                }
            }">
                <div class="space-y-6 lg:col-span-2">
                    <div
                        class="bg-surface/95 border border-on-background/5 backdrop-blur-xl flex items-center justify-between rounded-[--radius-xl] p-5 shadow-sm">
                        <div class="flex items-center gap-4">
                            <input name="allSelected" type="checkbox" x-model="allSelected" x-on:click="toggleAll"
                                class="h-6 w-6 rounded-md border-on-background/10 bg-background/50 text-primary focus:ring-primary/20">
                            <span class="text-on-background/80 font-bold tracking-tight"
                                x-text="'@lang('shop::app.checkout.cart.index.items-selected')'.replace(':count', selected.length)">
                            </span>
                        </div>

                        <button x-show="selected.length > 0"
                            class="hover:bg-danger/10 text-danger rounded-full px-4 py-2 text-sm font-bold transition-all"
                            wire:click="removeSelectedItems">
                            @lang('shop::app.checkout.cart.index.remove')
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach ($cart->items as $item)
                            <div
                                class="bg-surface/90 border border-on-background/5 backdrop-blur-xl group/card overflow-hidden rounded-[--radius-xl] p-6 transition-all duration-300 hover:bg-surface/100 shadow-sm">
                                <div class="flex gap-8">
                                    <div class="flex items-center">
                                        <input type="checkbox" value="{{ $item->id }}" name="selected[]"
                                            wire:model.number="itemsSelected" x-model.number="selected"
                                            @change="allSelected = (selected.length === items.length)"
                                            class="h-6 w-6 rounded-md border-on-background/10 bg-background/50 text-primary focus:ring-primary/20">
                                    </div>

                                    <div
                                        class="relative h-32 w-32 flex-shrink-0 overflow-hidden rounded-[--radius-lg] border border-on-background/5">
                                        <img src="{{ $item->base_image->small_image_url }}" alt="{{ $item->name }}"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover/card:scale-110">
                                    </div>

                                    <div class="flex flex-1 flex-col justify-between">
                                        <div class="flex items-start justify-between">
                                            <div class="min-w-0 flex-1">
                                                <h3
                                                    class="text-on-background truncate text-xl font-bold tracking-tight transition-colors group-hover/card:text-primary">
                                                    <a href="{{ url($item->product_url_key) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                </h3>

                                                <div class="mt-2 flex items-baseline gap-3">
                                                    @if ($this->shouldDisplayCartPricesIncludingTax())
                                                        <div class="text-primary text-lg font-black tracking-tight">
                                                            <x-shop::formatted-price :price="$item->price_incl_tax" />
                                                        </div>
                                                    @elseif ($this->shouldDisplayCartBothPrices())
                                                        <div class="text-primary text-lg font-black tracking-tight">
                                                            <x-shop::formatted-price :price="$item->price_incl_tax" />
                                                        </div>
                                                        <div
                                                            class="text-on-surface/40 text-xs font-bold uppercase tracking-widest">
                                                            @lang('shop::app.checkout.cart.mini-cart.excl-tax')
                                                            <x-shop::formatted-price :price="$item->price" />
                                                        </div>
                                                    @else
                                                        <div
                                                            class="text-on-surface/80 text-lg font-black tracking-tight">
                                                            <x-shop::formatted-price :price="$item->price" />
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <button
                                                class="hover:bg-danger/10 text-on-surface/30 hover:text-danger rounded-full p-2 transition-all"
                                                title="Remove item"
                                                x-on:click="$confirm(() => $wire.removeItem({{ $item->id }}))">
                                                <x-lucide-trash-2 class="h-5 w-5" />
                                            </button>
                                        </div>

                                        <div class="mt-4 flex items-center justify-between">
                                            <x-shop::quantity-selector :min="1" value="{{ $item->quantity }}"
                                                x-on:change="$wire.updateItemQuantity({{ $item->id }}, $event.detail)" />

                                            <div class="text-right">
                                                <div
                                                    class="text-on-surface/40 text-[10px] font-black uppercase tracking-widest">
                                                    @lang('shop::app.checkout.cart.index.total')</div>
                                                <div class="text-on-surface text-xl font-black tracking-tight">
                                                    <x-shop::formatted-price :price="$item->total" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-32 space-y-6">
                        <div
                            class="bg-surface/95 border border-on-background/5 backdrop-blur-xl overflow-hidden rounded-[--radius-2xl] p-8 shadow-2xl">
                            <h2 class="text-gradient mb-8 text-2xl font-black tracking-tight">
                                @lang('shop::app.checkout.cart.summary.cart-summary')
                            </h2>

                            @if (core()->getConfigData('sales.checkout.shopping_cart.estimate_shipping') && $haveStockableItems)
                                <div class="mb-8 rounded-[--radius-lg] bg-background/30 p-5">
                                    <livewire:estimate-shipping />
                                </div>
                            @endif

                            <div class="space-y-4">
                                <x-shop::cart.summary :cart="$cart" />
                            </div>

                            <div class="mt-10">
                                <x-shop::ui.button block href="{{ route('shop.checkout.onepage.index') }}"
                                    color="primary" class="h-14 shadow-lg shadow-primary/20">
                                    @lang('shop::app.checkout.cart.summary.proceed-to-checkout')
                                </x-shop::ui.button>
                            </div>
                        </div>

                        <div class="rounded-[--radius-xl] bg-primary/5 p-6 text-center">
                            <p class="text-on-background/40 text-xs font-bold uppercase tracking-[0.2em]">Secure
                                Checkout</p>
                            <div
                                class="mt-4 flex justify-center gap-4 opacity-30 grayscale transition-all hover:opacity-80 hover:grayscale-0">
                                <x-lucide-shield-check class="h-6 w-6" />
                                <x-lucide-lock class="h-6 w-6" />
                                <x-lucide-credit-card class="h-6 w-6" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
