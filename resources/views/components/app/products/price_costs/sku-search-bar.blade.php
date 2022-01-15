<x-template.forms.get
    :action="route('costs.product.list')"
>
    <div class="d-flex justify-content-around">
        <x-template.input.text
            attribute="sku"
            label="SKU"
            visibleComponentId="sku"
            value="{{ $sku }}"
        />

        <div class="d-flex align-items-end px-2">
            <x-template.buttons.submit label="Filtrar" />
        </div>
    </div>
</x-template.forms.get>