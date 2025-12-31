@php
    $direction = core()->getCurrentLocale()->direction;
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $direction }}">

<head>
    {!! view_render_event('bagisto.shop.layout.head.before') !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    @include('shop::partials.head')

    {!! view_render_event('bagisto.shop.layout.head.after') !!}
</head>

<body class="{{ $direction }}" style="scroll-behavior: smooth;">
    {!! view_render_event('bagisto.shop.layout.body.before') !!}

    <x-shop::toasts />

    <x-shop::confirm-modal />

    {!! view_render_event('bagisto.shop.layout.content.before') !!}

    <main role="main" tabindex="-1">
        @if ($theme->settings->enable_admin_bar)
            <visual:section name="visual-debut::admin-top-bar" />
        @endif

        @visualRegion('header')

        @section('body')
            @visual_layout_content
        @show

        @visualRegion('footer')
    </main>

    {!! view_render_event('bagisto.shop.layout.content.after') !!}

    {!! view_render_event('bagisto.shop.layout.body.after') !!}

    @stack('scripts')
    @livewireScriptConfig
</body>

</html>
