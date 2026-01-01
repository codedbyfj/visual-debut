<div {{ $section->editor_attributes }} class="relative overflow-hidden bg-primary/5 py-24">
    <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-primary/5 blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-accent/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-gradient mb-6 text-4xl font-bold tracking-tight sm:text-5xl"
                {{ $section->liveUpdate()->text('heading') }}>
                {{ $section->settings->heading }}
            </h2>
            <div class="text-on-surface/60 mx-auto mb-12 text-lg leading-relaxed"
                {{ $section->liveUpdate()->html('description') }}>
                {!! $section->settings->description !!}
            </div>

            <form method="POST" action="{{ route('shop.subscription.store') }}" class="mx-auto max-w-md">
                @csrf
                <div class="relative flex flex-col gap-4 sm:flex-row">
                    <input type="email" name="email" autocomplete="on" placeholder="Your email address"
                        class="h-14 flex-1 rounded-2xl border-on-background/10 bg-surface px-6 text-base focus:ring-4 focus:ring-primary/10 shadow-sm transition-all"
                        required>
                    <x-shop::ui.button type="submit" variant="primary" class="h-14 px-10 shadow-lg shadow-primary/20">
                        Subscribe
                    </x-shop::ui.button>
                </div>

                @error('email')
                    <p class="text-danger mt-3 text-sm font-medium">{{ $message }}</p>
                @enderror
            </form>

            <p class="text-on-surface/40 mt-6 text-xs font-medium">
                By subscribing, you agree to our Privacy Policy and Terms of Service.
            </p>
        </div>
    </div>
</div>
