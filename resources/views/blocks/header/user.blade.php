<div {{ $block->editor_attributes }} id="user-menu" x-data x-dropdown class="relative" @visual_design_mode
    x-on:visual:block:select:{{ $block->id }}.window="$dropdown.open = true"
    x-on:visual:block:deselect:{{ $block->id }}.window="$dropdown.open = false" @end_visual_design_mode>
    <button x-dropdown:trigger
        class="group hover:bg-on-background/10 flex h-11 w-11 items-center justify-center rounded-full transition-all duration-300"
        aria-label="user menu">
        @svg($block->settings->icon ?? 'lucide-user', ['class' => 'h-5 w-5 transition-transform group-hover:scale-110'])
    </button>
    <div x-cloak x-dropdown:content
        class="bg-surface/95 absolute end-0 mt-4 w-72 origin-top-right overflow-hidden rounded-[--radius-xl] border border-on-background/10 p-2 shadow-2xl backdrop-blur-xl">
        @guest('customer')
            <div class="p-5 text-center">
                <div class="bg-primary/5 text-primary mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full">
                    <x-lucide-user-circle class="h-8 w-8" />
                </div>
                <h3 class="mb-2 text-xl font-bold tracking-tight" {{ $block->liveUpdate()->text('guest_heading') }}>
                    {{ $block->settings->guest_heading }}
                </h3>
                <p class="text-on-surface/60 mb-8 text-sm leading-relaxed"
                    {{ $block->liveUpdate()->html('guest_description') }}>
                    {!! $block->settings->guest_description !!}
                </p>
                <div class="grid gap-3">
                    <x-shop::ui.button href="{{ route('shop.customer.session.create') }}" color="primary" class="h-11">
                        @lang('visual-debut::sections.header.blocks.user.sign-in')
                    </x-shop::ui.button>
                    <x-shop::ui.button variant="outline" href="{{ route('shop.customers.register.index') }}" class="h-11">
                        @lang('visual-debut::sections.header.blocks.user.sign-up')
                    </x-shop::ui.button>
                </div>
            </div>
        @endguest

        @auth('customer')
            @php
                $menuItems = collect([
                    [
                        'route' => 'shop.customers.account.profile.index',
                        'text' => __('visual-debut::shop.header.profile'),
                        'icon' => 'lucide-user-circle-2',
                        'show' => true,
                    ],
                    [
                        'route' => 'shop.customers.account.orders.index',
                        'text' => __('visual-debut::shop.header.orders'),
                        'icon' => 'lucide-package',
                        'show' => true,
                    ],
                    [
                        'route' => 'shop.customers.account.wishlist.index',
                        'text' => __('visual-debut::shop.header.wishlist'),
                        'icon' => 'lucide-heart',
                        'show' => !!core()->getConfigData('customer.settings.wishlist.wishlist_option'),
                    ],
                ])->filter(fn($item) => $item['show']);
            @endphp

            <div>
                <div class="bg-background/40 mb-2 rounded-[--radius-lg] border border-on-background/5 px-5 py-5">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-full border-2 border-primary/20">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->guard('customer')->user()->first_name }}+{{ auth()->guard('customer')->user()->last_name }}&background=6366f1&color=fff"
                                class="h-full w-full object-cover">
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-on-surface truncate font-bold leading-tight">
                                {{ auth()->guard('customer')->user()->first_name }}
                            </p>
                            <p class="text-on-surface/40 truncate text-xs font-medium">
                                {{ auth()->guard('customer')->user()->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    @foreach ($menuItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="hover:bg-background/60 text-on-surface group flex items-center gap-3 rounded-[--radius-md] px-4 py-2.5 text-sm font-bold tracking-tight transition-all">
                            <div class="text-on-surface/30 group-hover:text-primary transition-colors">
                                @svg($item['icon'], ['class' => 'h-5 w-5'])
                            </div>
                            {{ $item['text'] }}
                        </a>
                    @endforeach
                </div>

                <div class="mt-2 border-t border-on-background/5 pt-2">
                    <form method="POST" action="{{ route('shop.customer.session.destroy') }}">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="hover:bg-danger/10 text-on-surface/60 hover:text-danger group flex w-full items-center gap-3 rounded-[--radius-md] px-4 py-2.5 text-sm font-bold tracking-tight transition-all text-left">
                            <x-lucide-log-out class="h-5 w-5 opacity-40 group-hover:opacity-100" />
                            @lang('visual-debut::shop.header.logout')
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</div>
