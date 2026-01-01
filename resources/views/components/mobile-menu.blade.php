@props(['categories'])

<ul class="divide-on-background/5 border-on-background/5 space-y-1 border-t pt-4" role="navigation">
    @foreach ($categories as $category)
        @if ($category->children->isEmpty())
            <li>
                <a href="{{ $category->url }}"
                    class="text-on-background block rounded-[--radius-lg] px-4 py-3 text-sm font-bold tracking-tight transition-all hover:bg-primary/5 hover:text-primary">
                    {{ $category->name }}
                </a>
            </li>
        @else
            <li x-collapsible>
                <button type="button"
                    class="text-on-background flex w-full items-center justify-between rounded-[--radius-lg] px-4 py-3 text-sm font-bold tracking-tight transition-all hover:bg-primary/5 hover:text-primary"
                    x-collapsible:trigger>
                    <span>{{ $category->name }}</span>
                    <x-lucide-chevron-right x-collapsible:indicator
                        class="h-4 w-4 transform transition-transform data-[state=open]:rotate-90" />
                </button>
                <div x-collapsible:content class="space-y-1 p-2 pl-4">
                    @foreach ($category->children as $subCategory)
                        <a href="{{ $subCategory->url }}"
                            class="text-on-background/60 hover:text-primary block rounded-[--radius-md] px-4 py-2 text-sm font-medium transition-all hover:bg-primary/5">
                            {{ $subCategory->name }}
                        </a>
                    @endforeach
                </div>
            </li>
        @endif
    @endforeach
</ul>

<div class="border-on-background/5 mt-4 border-t px-4 py-3">
    <x-shop::currency-selector mobile />
</div>

<div class="border-on-background/5 mt-4 border-t px-4 py-3 pb-24">
    <x-shop::language-selector mobile />
</div>

<div class="border-on-background/5 absolute bottom-0 left-0 right-0 border-t bg-background/80 p-4 backdrop-blur-lg">
    <a href="@auth('customer') {{ route('shop.customers.account.profile.index') }}  @else {{ route('shop.customer.session.create') }} @endauth"
        class="text-on-background hover:bg-primary/5 group flex items-center justify-between rounded-[--radius-xl] px-4 py-4 transition-all">
        <span class="flex items-center font-bold tracking-tight">
            <x-lucide-user class="text-primary/40 group-hover:text-primary mr-3 h-5 w-5 transition-colors" />
            @auth('customer')
                @lang('visual-debut::shop.header.profile')
            @else
                @lang('visual-debut::shop.header.sign-in')
            @endauth
        </span>
        <x-lucide-chevron-right class="h-5 w-5 opacity-20" />
    </a>
</div>
