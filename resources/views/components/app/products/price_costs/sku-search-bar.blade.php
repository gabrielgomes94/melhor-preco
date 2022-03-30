<x-bootstrap.forms.form.get
    :action="route('costs.product.list')"
>
    <div class="d-flex justify-content-around">
        <x-bootstrap.input.text
            attribute="sku"
            label="SKU"
            visibleComponentId="sku"
            value="{{ $sku }}"
        />

        <div class="d-flex align-items-end px-2">
            <x-bootstrap.buttons.submit label="Filtrar" />
        </div>
    </div>
</x-bootstrap.forms.form.get>
