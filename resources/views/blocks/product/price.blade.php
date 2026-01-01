@isset($product)
    <div {{ $block->editor_attributes }} x-data="VisualProductPrices" x-bind="bindings"
        class="text-[#E32E2E] flex items-center gap-2 text-xl font-black tracking-tight">
        {!! $product->getTypeInstance()->getPriceHtml() !!}
    </div>
@else
    @visual_design_mode
    <div {{ $block->editor_attributes }}>
        <div class="text-primary flex items-center gap-2 text-lg font-medium">
            <x-shop::formatted-price price="20" />
        </div>
    </div>
    @end_visual_design_mode
@endisset
